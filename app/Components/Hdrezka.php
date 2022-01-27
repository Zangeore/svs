<?php

namespace App\Components;

use App\Models\Film;
use App\Models\FilmQuality;
use App\Models\ParseService;
use DiDom\Document;
use GuzzleHttp\Client;
use PhpParser\Node\Stmt\DeclareDeclare;

class Hdrezka
{
    public $header = ['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'];
    public $html;
    public $document;
    public $id;
    public $url;
    public $filmModel;

    /**
     * @throws \DiDom\Exceptions\InvalidSelectorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct($url)
    {
        $this->url = $url;
        $client = new Client([
            'headers' => $this->header,
            'curl' => [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ]
        ]);
        $response = $client->get($url);
        $this->html = $response->getBody()->getContents();
        $this->document = new Document();
        $this->document->loadHtml($this->html);
        $this->id = $this->getId();
        $this->createFilmModelIfDontExist();
    }

    public function getTranslations(): array
    {

        $transListElement = $this->document->find('#translators-list');
        $trans = [];
        if ($transListElement) {
            foreach ($transListElement as $post) {
                $transElements = $post->find('li');
                foreach ($transElements as $value) {
                    $trans[] = ['title' => strip_tags($value->innerHtml()), 'id' => $value->attr('data-translator_id')];
                }
            }
        } else {
            $trans[] = ['title' => 'Озвучка', 'id' => $this->getUniversalTranslationId()];
        }
        return $trans;
    }

    public function getSeasons($translator)
    {
        $client = new Client([
            'headers' => $this->header,
            'curl' => [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ],
            'form_params' => [
                'id' => $this->id,
                'translator_id' => $translator,
                'action' => 'get_episodes'
            ],
        ]);
        $response = $client->post('https://rezka.ag/ajax/get_cdn_series/?t=1590958856022');
        $data = json_decode($response->getBody()->getContents(), true);
        $seasonsRaw = null;
        if ($data['success']) {
            $seasonsRaw = $data['seasons'];
        }
        $seasons = $this->document->load($seasonsRaw);
        $seasons = $seasons->find('li');
        $seasonsData = [];
        foreach ($seasons as $season) {
            $seasonsData[$season->attr('data-tab_id')] = ['title' => $season->innerHtml()];
        }
        $seasonsData = $this->parseEpisodes($data['episodes'], $seasonsData);
        return $seasonsData;
    }

    public function getStream($translator, $season, $episode)
    {
        $client = new Client([
            'headers' => $this->header,
            'curl' => [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ],
            'form_params' => [
                'id' => $this->id,
                'translator_id' => $translator,
                'season' => $season,
                'episode' => $episode,
                'action' => 'get_stream'
            ],
        ]);
        $response = $client->post('https://rezka.ag/ajax/get_cdn_series/?t=1590958856022');
        $data = json_decode($response->getBody()->getContents(), true);
        $urls = $this->getClearUrl($data['url']);
        $this->createFilmQualityModelIfDontExist($urls, $translator);
        return $urls;
    }

    public function getChapters(): array
    {
        $parts = $this->document->find('.b-post__partcontent_item');
        $chapters = [];
        if ($parts) {
            foreach ($parts as $part) {
                $chapter = $part->find('.title')[0]->firstChild();
                if ($chapter->firstChild()) {
                    $chapters[] = ['title' => $chapter->innerHtml(), 'url' => $chapter->attr('href')];
                } else {
                    $chapters[] = ['title' => $chapter->html(), 'url' => 'current'];
                }
            }
        }
        $chapters = array_reverse($chapters);
        return $chapters;
    }

    /**
     * @throws \DiDom\Exceptions\InvalidSelectorException
     */
    private function getId()
    {
        return $this->document->find('#post_id')[0]->attr('value');
    }

    private function getUniversalTranslationId()
    {
        $id = strip_tags(explode(',', explode('{', last((explode('sof.tv.initCDNSeriesEvents', $this->html))))[0])[1]);
        return $id;
    }

    private function parseEpisodes($episodes, $seasons)
    {
        $this->document->load($episodes);
        $episodes = $this->document->find('.b-simple_episode__item');
        foreach ($episodes as $episode) {
            $seasons[$episode->attr('data-season_id')]['episodes'][$episode->attr('data-episode_id')] = $episode->innerHtml();
        }
        return $seasons;
    }

    private function getClearUrl($data)
    {
        $clearUrls = [];
        $trashList = [b'QEA=', b'QCM=', b'QCE=', b'QF4=', b'QCQ=', b'I0A=', b'IyM=', b'IyE=', b'I14=', b'IyQ=', b'IUA=', b'ISM=', b'ISE=', b'IV4=', b'ISQ=', b'XkA=', b'XiM=', b'XiE=', b'Xl4=', b'XiQ=', b'JEA=', b'JCM=', b'JCE=', b'JF4=', b'JCQ=', b'QEBA', b'QEAj', b'QEAh', b'QEBe', b'QEAk', b'QCNA', b'QCMj', b'QCMh', b'QCNe', b'QCMk', b'QCFA', b'QCEj', b'QCEh', b'QCFe', b'QCEk', b'QF5A', b'QF4j', b'QF4h', b'QF5e', b'QF4k', b'QCRA', b'QCQj', b'QCQh', b'QCRe', b'QCQk', b'I0BA', b'I0Aj', b'I0Ah', b'I0Be', b'I0Ak', b'IyNA', b'IyMj', b'IyMh', b'IyNe', b'IyMk', b'IyFA', b'IyEj', b'IyEh', b'IyFe', b'IyEk', b'I15A', b'I14j', b'I14h', b'I15e', b'I14k', b'IyRA', b'IyQj', b'IyQh', b'IyRe', b'IyQk', b'IUBA', b'IUAj', b'IUAh', b'IUBe', b'IUAk', b'ISNA', b'ISMj', b'ISMh', b'ISNe', b'ISMk', b'ISFA', b'ISEj', b'ISEh', b'ISFe', b'ISEk', b'IV5A', b'IV4j', b'IV4h', b'IV5e', b'IV4k', b'ISRA', b'ISQj', b'ISQh', b'ISRe', b'ISQk', b'XkBA', b'XkAj', b'XkAh', b'XkBe', b'XkAk', b'XiNA', b'XiMj', b'XiMh', b'XiNe', b'XiMk', b'XiFA', b'XiEj', b'XiEh', b'XiFe', b'XiEk', b'Xl5A', b'Xl4j', b'Xl4h', b'Xl5e', b'Xl4k', b'XiRA', b'XiQj', b'XiQh', b'XiRe', b'XiQk', b'JEBA', b'JEAj', b'JEAh', b'JEBe', b'JEAk', b'JCNA', b'JCMj', b'JCMh', b'JCNe', b'JCMk', b'JCFA', b'JCEj', b'JCEh', b'JCFe', b'JCEk', b'JF5A', b'JF4j', b'JF4h', b'JF5e', b'JF4k', b'JCRA', b'JCQj', b'JCQh', b'JCRe', b'JCQk'];
        $trashData = str_replace('//_//', '', substr($data, 2));
        foreach ($trashList as $value) {
            $trashData = str_replace(utf8_decode($value), '', $trashData);
        }
        $decodedUrls = utf8_decode(base64_decode($trashData));
        $resUrls = explode(',', $decodedUrls);
        foreach ($resUrls as $url) {
            $res = explode(']', explode('[', $url)[1])[0];
            $url = explode('or', explode(']', explode('[', $url)[1])[1])[1];
            $clearUrls[$res] = $url;
        }
        return $clearUrls;
    }

    private function createFilmModelIfDontExist()
    {
        $film = Film::query()->where('source_link', $this->url)->get()->first;
        if (!$film) {
            $params['title'] = $this->document->find('.b-post__title')[0]->child(1)->innerHtml();;
            $params['id'] = $this->id;
            $params['link'] = $this->url;
            $params['cover_url'] = $this->document->find('.b-sidecover')[0]->child(1)->attr('href');
            $params['service'] = ParseService::HDREZKA;
            $this->filmModel = Film::createFilmModel($params);
        } else {
            $this->filmModel = $film;
        }
    }

    private function createFilmQualityModelIfDontExist($streams, $translator_id)
    {
        foreach ($streams as $res => $stream) {
            $film = FilmQuality::query()->where([
                ['film_id', '=', $this->filmModel->id],
                ['translator_id', '=', $translator_id],
                ['stream_url', '=', $stream],
                ['quality', '=', $res],
            ])->get()->first;
            if ($film) {
                continue;
            }
            $params = [];
            $params['film_id'] = $this->filmModel->id;
            $params['translator_id'] = $translator_id;
            $params['stream_url'] = $stream;
            $params['quality'] = $res;
            FilmQuality::createModel($params);

        }

    }

}
