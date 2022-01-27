<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmQuality extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'films_quality';
    protected $fillable = [
        'film_id',
        'stream_url',
        'translator',
        'quality',
    ];

    public function getFilm()
    {
        $this->hasOne(Film::class, 'id', 'film_id');
    }

    public static function createModel($params)
    {
        $model = new self();
        $model->film_id = $params['film_id'];
        $model->stream_url = $params['stream_url'];
        $model->translator = $params['translator'];
        $model->quality = $params['quality'];
        $model->save();
    }
}
