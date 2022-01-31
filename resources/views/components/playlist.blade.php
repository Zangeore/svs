<ul class="overflow-y-scroll w-full h-full bg-neutral-600">
    @foreach($playlist as $film)
        <li class="max-h-36 flex px-4 py-4 flex">
            <div class="w-full h-full flex">
                <img src="{{$film->cover_url}}" class="max-h-36 w-20 pr-4">
                <p class="text-white">{{$film->title}}</p>
            </div>
            <button id="remove_from_playlist" data-id="{{$film->id}}"><i class=" text-white p-4 fas fa-times"></i></button>
        </li>
    @endforeach
</ul>
