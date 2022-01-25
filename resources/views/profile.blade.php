@extends('layouts.app')
@section('content')
    <form class="h-full flex flex-1 w-full bg-neutral-800">
        <div class="w-full min-h-full flex justify-evenly">
            <div class="bg-neutral-700/[.2] px-16 flex  justify-center flex-col">
                @if($user->photo)
                    <img src="{{$user->photo}}" class="rounded-full">
                @else
                    <img src="/images/logo.png" class="rounded-full max-h-72 my-14">
                @endif

                <input type="file" name="profile_img">
            </div>
            <button type="submit"><img class="w-28 opacity-25 shadow-md" src="/images/sync.png"></button>
            <div class="bg-neutral-700/[.2] px-16 h-full flex flex-col justify-center">
                <div class="mt-4">
                    <x-label for="name" :value="__('Имя')"/>
                    <x-input id="name" class="block mt-1 w-full" type="text" name="username" :value="old('name')"/>

                </div>
                <div class="mt-4">
                    <x-label for="password" :value="__('Пароль')"/>

                    <x-input id="password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             autocomplete="new-password"/>
                </div>
                <div class="mt-4">
                    <x-label for="password_confirmation" :value="__('Подтвердить Пароль')"/>

                    <x-input id="password_confirmation" class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation"/>
                </div>

            </div>
        </div>
    </form>

@stop
