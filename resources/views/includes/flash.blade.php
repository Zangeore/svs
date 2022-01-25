@if ($message = Session::get('success'))

    <div class="opacity-45 bg-lime-600 py-8 px-10 flex justify-center align-middle text-white">
        <strong>{{ $message }}</strong>
    </div>

@endif


@if ($message = Session::get('error'))

    <div class="opacity-45 bg-red-600 py-8 px-10 flex justify-center align-middle text-white">
        <strong>{{ $message }}</strong>
    </div>

@endif


@if ($message = Session::get('warning'))

    <div class="opacity-45 bg-amber-400 py-8 px-10 flex justify-center align-middle text-white">
        <strong>{{ $message }}</strong>
    </div>

@endif


@if ($message = Session::get('info'))

    <div class="opacity-45 bg-sky-700 py-8 px-10 flex justify-center align-middle text-white">
        <strong>{{ $message }}</strong>
    </div>

@endif
