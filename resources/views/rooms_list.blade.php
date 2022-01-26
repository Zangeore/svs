@extends('layouts.app')
@section('content')

        <div class="justify-center flex flex-[1_0_auto] h-full w-full bg-neutral-800">
            <ul>
            @foreach($rooms as $room)
                <li>{{$room->uuid}}</li>
            @endforeach
            </ul>
        </div>

@stop
