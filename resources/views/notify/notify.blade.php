<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">

</head>
<body class="bg-black">
  {{-- {{ dd(session('user_id')) }} --}}
     <section class="bg-black h-screen">

<div class="fixed md:top-0 bottom-0 md:left-0 w-full md:w-[100px] h-[60px] md:h-screen flex md:flex-col justify-between items-center bg-black text-white p-2 z-50">
        <!-- Top Logo -->
        <div class="text-3xl p-3 hidden md:block">
            <i class="fa-solid fa-cloud"></i>
        </div>

        <!-- Navigation Items -->
        <div class="flex md:flex-col justify-around md:justify-start bg-transparent md:rounded-xl p-3 gap-5 shadow-lg w-full md:w-16 items-center">
            @php
                $navItems = [
                    ['route' => 'welcome', 'icon' => 'fa-house', 'label' => 'Home' , 'class' => 'text-2xl p-3 rounded-xl bg-transparent'],
                    ['route' => 'search.account', 'icon' => 'fa-magnifying-glass', 'label' => 'Search' , 'class' => 'text-2xl p-3 rounded-xl bg-transparent'],
                    ['route' => 'post.something', 'icon' => 'fa-plus', 'label' => 'Post' , 'class' => 'text-3xl p-3 rounded-xl bg-[#2D2D2D]'],
                    ['route' => 'notify.user', 'icon' => 'fa-heart', 'label' => 'Likes' , 'class' => 'text-2xl p-3 rounded-xl bg-transparent', 'notification' => ['class' => 'w-[10px] h-[10px] bg-red-400 rounded-full absolute top-[5px] left-[35px]']],
                    ['route' => 'show.user.account', 'icon' => 'fa-user', 'label' => 'Profile' , 'class' => 'text-2xl p-3 rounded-xl bg-transparent'],
                ];
            @endphp

            @foreach ($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['route']);
                @endphp
                <a href="{{ route($item['route']) }}"
                   class="group relative flex items-center justify-center w-12 h-12 rounded-lg transition-all duration-200 
                       {{ $isActive ?  'text-white shadow-inner' : 'text-[#404040] hover:text-white hover:bg-[#2a2a2a]' }}">
                    <div class="relative">
                        <i class="fa-solid {{ $item['icon'] }} {{ $item['class'] }}"></i>
                        @if (!empty($item['notification']))
                            <div id='notify' class="{{ $item['notification']['class'] }}"></div>
                        @endif
                    </div>
                    <!-- Tooltip (hidden on small screens) -->
                    <span class="absolute left-14 opacity-0 group-hover:opacity-100 bg-white text-black text-sm rounded px-2 py-1 shadow transition-opacity duration-300 hidden md:block">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Logout -->
        <div class="hidden md:block">
            @if(Auth::check())
                <a href="{{ URL('logout') }}" class="text-3xl text-[#404040] p-3 duration-200 hover:opacity-100"
                   onclick="return confirm('Are you sure you want to logout?');">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            @endif
        </div>
    </div>
        
        <div class="flex flex-col justify-center items-center w-full h-screen p-5 capitalize text-white">
          <div class="bg-[#151515] flex flex-col w-full md:w-[600px] h-screen rounded-md p-5 overflow-y-auto">
            <h1 class="text-center text-3xl font-extrabold capitalize text-white p-2">notifications</h1>
            <div id="todays-notification" class="mt-5">
                <h1 class="text-left text-xl font-bold capitalize text-white p-2">today's</h1>
                <div id="today" class="px-[20px] mt-[10px]">
                    <h1 id='toady-no' class="text-sm font-light capitalize"></h1>
                </div>
            <div class="flex flex-col space-y-4 mt-3 l">
                 @for ($i = 1; $i <= 2; $i++)
               <!-- From Uiverse.io by Deri-Kurniawan --> 
        <div class="flex flex-row gap-2">
        <div class="animate-pulse bg-gray-300 w-12 h-12 rounded-full"></div>
        <div class="flex flex-col gap-2">
        <div class="animate-pulse bg-gray-300 w-28 h-5 rounded-full"></div>
        <div class="animate-pulse bg-gray-300 w-[250px] h-5 rounded-full"></div>
        </div>
        </div>
            @endfor
            </div>
        </div>
            <div id="tommorows-notification" class="mt-5">
                <h1 class="text-left text-xl font-bold capitalize text-white p-2">recent day's</h1>
                <div id="tomorrow" class="px-[20px] mt-[10px]">
                    <h1 id='tommo-no' class="text-sm font-light capitalize"></h1>
                </div>
            <div class="flex flex-col space-y-4 mt-3 l">
                 @for ($i = 1; $i <= 2; $i++)
               <!-- From Uiverse.io by Deri-Kurniawan --> 
        <div class="flex flex-row gap-2">
        <div class="animate-pulse bg-gray-300 w-12 h-12 rounded-full"></div>
        <div class="flex flex-col gap-2">
        <div class="animate-pulse bg-gray-300 w-28 h-5 rounded-full"></div>
        <div class="animate-pulse bg-gray-300 w-[250px] h-5 rounded-full"></div>
        </div>
        </div>
            @endfor
            </div>
        </div>
            <div id="week-ago" class="mt-5">
                <h1 class="text-left text-xl font-bold capitalize text-white p-2">week ago</h1>
            <div id="week" class="px-[20px] mt-[10px]">
                <h1 id='week-no' class="text-sm font-light capitalize"></h1>
            </div>
            <div class="flex flex-col space-y-4 mt-3 l">
                 @for ($i = 1; $i <= 2; $i++)
               <!-- From Uiverse.io by Deri-Kurniawan --> 
        <div class="flex flex-row gap-2">
        <div class="animate-pulse bg-gray-300 w-12 h-12 rounded-full"></div>
        <div class="flex flex-col gap-2">
        <div class="animate-pulse bg-gray-300 w-28 h-5 rounded-full"></div>
        <div class="animate-pulse bg-gray-300 w-[250px] h-5 rounded-full"></div>
        </div>
        </div>
            @endfor
            </div>
        </div>
          </div>
    </div>

    </section> 

     <script src="{{asset('js/notify.js')}}"></script>
</body>
</html>