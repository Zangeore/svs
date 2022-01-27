<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParseService extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'parse_services';
    protected $fillable = [
        'title',
    ];

    public const HDREZKA = 'hrezka';
}
