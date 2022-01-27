@extends('layouts.app')
@section('content')

    <div class="justify-center flex flex-[1_0_auto] h-full w-full bg-neutral-800">
        <ul class="py-6 flex flex-wrap">
            @foreach($rooms as $room)
                <li class="px-6 py-4">
                    <div class="bg-neutral-700 max-h-36 flex w-[36rem] rounded-md">
                        <a href="{{$room['url']}}" class="flex w-full max-h-full items-center">
                            <img src="{{$room['cover']}}" class="max-h-24 px-4 py-4">
                            <div class="w-full max-h-full flex flex-col items-center text-white">
                                <p class="w-6 py-1"><strong>{{__('Плейлист')}}</strong></p>
                                <ul class=" overflow-y-scroll w-full h-full bg-neutral-600">
                                    @foreach($room['playlist'] as $film)
                                        <li class="max-h-12 flex px-4 py-4">
                                            <img src="{{$film->cover_url}}" class="max-h-12 w-12 pr-4">
                                            <p class="text-white">{{$film->title}}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

@stop
