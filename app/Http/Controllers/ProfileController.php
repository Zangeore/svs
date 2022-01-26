<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::query()->where('id', auth()->id())->first();
        $filmIds = is_array($user->history) ? array_keys($user->history) : null;
        $history = [];
        if ($filmIds) {
            $history = Film::query()->whereIn('id', $filmIds)->get()->all();
        }
        return view('profile', ['history' => $history, 'user' => $user]);
    }

    public function update(Request $request)
    {
        try {
            $user = User::query()->where('id', auth()->id())->first();
            if ($request->hasFile('profile_img')) {
                $request->validate([
                    'image' => 'array',
                    'image.*' => 'mimes:jpeg,jpg,bmp,png' // Only allow .jpg, .bmp and .png file types.
                ]);
                $file = $request->file('profile_img');
                $image = Image::make($file->getRealPath())->resize(200, 200, function ($const) {
                    $const->aspectRatio();
                })->save(storage_path('app/public/product/temp.'. $file->extension()));
                $user->photo = $image->encoded;
                unlink($image->basePath());
            }
            if ($request->request->get('username')) {
                $request->validate([
                    'username' => ['required', 'string', 'max:255'],
                ]);
                $user->name = $request->request->get('username');
            }
            if (($request->request->get('password') && $request->request->get('password_confirmation')) && ($request->request->get('password') == $request->request->get('password_confirmation'))) {
                $request->validate([
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);
                $user->password = Hash::make($request->request->get('password'));
            }
            $user->save();
            return back()->with('success', 'Данные успешно сохранены');

        } catch (\Exception $exception) {
            Log::error($exception);
            return back()->with('error', 'Ошибка, проверьте верность введенных данных и попробуйте позже');
        }
    }
}
