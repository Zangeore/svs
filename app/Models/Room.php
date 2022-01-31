<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    protected $table = 'rooms';
    public $timestamps = false;
    protected $fillable = [
        'uuid',
        'owner_id',
        'playlist',
        'active_to',
    ];

    public function getPlaylist(): array
    {
        $films = [];
        if (!$this->playlist){
            return  $films;
        }
        $playlist = array_keys(json_decode($this->playlist, true));
        if ($playlist){
            $films = Film::query()->whereIn('id', $playlist)->get()->all();
        }
        return $films;
    }
}
