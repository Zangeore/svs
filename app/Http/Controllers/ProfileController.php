<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::query()->where('id', auth()->id())->first();
        $filmIds = is_array($user->history) ? array_keys($user->history) : null;
        $history = [];
        if ($filmIds){
            $history = Film::query()->whereIn('id', $filmIds)->get()->all();
        }
        return view('profile', ['history' => $history, 'user' => $user]);
    }
}
