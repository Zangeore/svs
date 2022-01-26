@extends('layouts.app')
@section('content')
    <form class="h-full flex flex-1 w-full bg-neutral-800" method="POST" action="{{ route('profile') }}"
          enctype="multipart/form-data">
        @csrf
        <div class="w-full min-h-full flex justify-evenly">
            <div class="bg-neutral-700/[.2] px-16 flex  justify-center flex-col max-w-[416px]">
                <div class="relative">
                    @if($user->photo)
                        <img id="profile_pic" src="{{$user->getProfilePhoto()}}"
                             class="relative rounded-full max-h-72 my-14">
                    @else
                        <img id="profile_pic" src="/images/logo.png" class="relative rounded-full max-h-72 my-14">
                    @endif
                    <div
                        class="top-[19rem] left-[14rem] absolute flex justify-center items-center rounded-full bg-neutral-300 h-1 w-1  p-5">
                        <i class="fas fa-pen" id="photo_input_icon"></i>
                        <input class="hidden" id="profile_img_input" type="file" name="profile_img">
                    </div>
                </div>
            </div>
            <button type="submit"><img class="hover:opacity-25 w-28 opacity-50" src="/images/sync.png"></button>
            <div class="bg-neutral-700/[.2] px-16 h-full flex flex-col justify-center">
                <div class="mt-4">
                    <x-label for="name" :value="__('Имя')"/>
                    <x-input id="name" class="block mt-1 w-full" type="text" name="username" value="{{$user->name}}"/>

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

