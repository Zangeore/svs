<?php

namespace App\Http\Controllers;


use App\Components\Hdrezka;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        (new Hdrezka('https://rezka.ag/films/drama/45532-rey-donovan-film-2022.html'));
        die;

        return view('room');
    }

    public function list()
    {
        $userId = auth()->id();
        $rooms = Room::query()->where('owner_id', $userId)->get()->all();
        $roomsPresent = [];
        foreach ($rooms as $room){
            $cover = '/images/logo.png';
            $playlist = $room->getPlaylist();
            $roomsPresent[] = ['cover' => $playlist ? $playlist[0]->cover_url : $cover, 'url' => route('room', ['uuid' => $room->uuid]), 'playlist' => $playlist ];
        }

        return view('rooms_list', ['rooms' => $roomsPresent]);
    }

}
