<?php

namespace App\Http\Controllers;


use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        return view('room');
    }

    public function list()
    {
        $userId = auth()->id();
        $rooms = Room::query()->where('owner_id', $userId)->get()->all();

        return view('rooms_list', ['rooms' => $rooms]);
    }

}
