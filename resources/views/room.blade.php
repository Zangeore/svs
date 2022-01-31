@extends('layouts.app')
@section('content')

    <div class="main flex flex-[1_0_auto] h-full w-full bg-neutral-800 overflow-hidden">
        <div class="w-[50%]">
            <div id="player" class="bg-black w-full h-[50%]">
                {{view('components.player')}}
            </div>
            <div>

            </div>
        </div>
        <div id="playlist_block" class="w-[25%] pl-5 bg-neutral-900">
            <p class="py-3 justify-center flex w-full text-white"><strong>{{__('Плейлист')}}</strong> </p>
            {{view('components.playlist', ['playlist' => $playlist])}}
        </div>
        <div class="w-[25%]">
        </div>
    </div>
@stop
<script>
    let removeFilmUrl = '{{route('room/film/delete')}}';
    let roomUuid = '{{$room->uuid}}';
</script>
