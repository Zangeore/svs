<header class="w-full h-12 bg-neutral-900 flex">
    <div class="max-h-12 pl-5"><img class="rounded-md h-full" src="/images/logo.png"></div>
    <ul class="flex justify-evenly list-none w-full h-full text-center items-center text-slate-50">
        <li class="bg-neutral-700/[.6] items-center h-[85%] flex px-[100px] rounded" ><a>Главная</a></li>
        <li class="bg-neutral-700/[.6] items-center h-[85%] flex px-[100px] rounded"><a href="{{route('rooms')}}">Мои комнаты</a></li>
        <li class="bg-neutral-700/[.6] items-center h-[85%] flex px-[100px] rounded"><a href="{{ route('profile') }}">Профиль</a></li>
        <li class="bg-neutral-700/[.6] items-center h-[85%] flex px-[100px] rounded"><a href="{{ route('logout') }}">Выйти</a></li>
    </ul>
</header>
