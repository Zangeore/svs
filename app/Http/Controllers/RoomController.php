<?php

namespace App\Http\Controllers;

use App\Components\Hdrezka;
use Illuminate\Routing\Controller as BaseController;

class RoomController extends BaseController
{
    public function index()
    {
        return view('room');
    }
}
