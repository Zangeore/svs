<?php

namespace App\Http\Controllers;


use App\Components\Hdrezka;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index($uuid)
    {
        $room = Room::query()->where('uuid', $uuid)->get()->first();
        $playlist = $room->getPlaylist();

        return view('room', ['room' => $room, 'playlist' => $playlist]);
    }

    public function list()
    {
        $userId = auth()->id();
        $rooms = Room::query()->where('owner_id', $userId)->get()->all();
        $roomsPresent = [];
        foreach ($rooms as $room) {
            $cover = '/images/logo.png';
            $playlist = $room->getPlaylist();
            $roomsPresent[] = ['uuid' => $room->uuid, 'cover' => $playlist ? $playlist[0]->cover_url : $cover, 'url' => route('room', ['uuid' => $room->uuid]), 'playlist' => $playlist];
        }

        return view('rooms_list', ['rooms' => $roomsPresent]);
    }

    public function delete($uuid)
    {
        $userId = auth()->id();
        $room = Room::query()->where([['owner_id', $userId], ['uuid', $uuid]])->get()->first();
        if (!$room) {
            return back()->with('error', 'Комната не существует либо не принадлежит вам');
        }
        $room->delete();
        return back()->with('success', 'Комната успешно удалена');

    }

    public function deleteFilm(Request $request)
    {
        $uuid = $request['uuid'];
        $id = $request['id'];
        $userId = auth()->id();
        $room = Room::query()->where([['owner_id', $userId], ['uuid', $uuid]])->get()->first();
        if (!$room) {
            return back()->with('error', 'Комната не существует либо не принадлежит вам');
        }
        if (!$room->playlist) {
            return view('components.playlist', ['playlist' => []]);
        }
        $films = json_decode($room->playlist, true);
        unset($films[$id]);
        $room->playlist = json_encode($films);
        $room->save();
        return view('components.playlist', ['playlist' => $room->getPlaylist()]);
    }

}
