<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'films';
    protected $fillable = [
        'title',
        'external_id',
        'parse_from',
        'source_link',
        'cover_url',
    ];

    public static function createFilmModel($params)
    {
        $film = new self();
        $film->title = $params['title'];
        $film->external_id = $params['id'];
        $film->parse_from = $params['service'];
        $film->source_link = $params['link'];
        $film->cover_url = $params['cover_url'];
        $film->save();
        return $film;
    }
}
