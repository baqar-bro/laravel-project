<!DOCTYPE html>
<html lang="en">
<head>
    <meta name='csrf-token' content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title class="capitalize">search user</title>
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
</head>
<body>
    <section class="bg-black h-screen overflow-y-auto">
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

        {{-- search --}}
        <div id='search_page' class="flex flex-col justify-center items-center h-screen w-full p-5">
            <div class="flex flex-col border w-full md:w-[600px] h-screen overflow-y-auto rounded-md bg-[#2D2D2D] gap-[10px]">
        <form id="form" method="get" class="p-5 w-full">
        @csrf
       <div class="relative w-full">
    
    <input
        type="search"
        id="search"
        placeholder="Search by user name..."
        required
        class="w-full pr-32 pl-4 py-3 text-white border border-gray-100 rounded-md font-light bg-transparent placeholder:text-gray-400 focus:outline-none"
    />

    <button
        type="submit"
        class="absolute top-1/2 right-2 transform -translate-y-1/2 px-4 py-2 bg-white text-black text-sm font-medium rounded-md hover:bg-gray-200 transition-all duration-150 cursor-pointer"
    >
        Search
    </button>
</div>
        </form>

        {{-- search-content --}}
        <div class="p-5 flex w-full h-full overflow-y-auto text-white">
            <div id='search_content' class="w-full">

            {{-- loading --}}
            <!-- From Uiverse.io by Nawsome --> 
           <div id="loading" class="hidden">
             @for ($i=1; $i<=4; $i++)
                <div class="search">
              <div class="wrapper">
                <div class="circle"></div>
                <div class="line-2"></div>
              </div>
            </div>
            @endfor
           </div>

            </div>
        </div>
        </div>
        </div>
    </section>

    <script>
        window.fetchAccRoute = " {{ route('get.all.accounts') }} ";
    </script>

<script src="{{ asset('js/search_acc.js') }}"></script>

</body>
</html>