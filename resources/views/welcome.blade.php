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
     <section class="min-h-screen flex flex-col md:flex-row">
    <!-- Navigation -->
    <div class="fixed bottom-0 w-full md:w-[100px] md:h-screen flex md:flex-col justify-between items-center bg-black/80 text-white p-2 z-50">
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

    <!-- Main Content -->
    <div class="flex flex-col justify-center items-center w-full p-3 gap-2">
        <!-- Top Center Banner -->
        <div>
            @if(Auth::check())
                <p class="fixed top-1 left-1/2 transform -translate-x-1/2 text-center capitalize p-2 text-white bg-black z-50 shadow-md rounded-xl font-light">for you</p>
            @else
                <div class="fixed top-0 left-1/2 transform -translate-x-1/2 text-center capitalize p-3 text-white bg-black z-50 shadow-md rounded-md font-light">
                    <a href="{{ route('register') }}" class="capitalize inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">register</a>
                    <a href="{{ route('login') }}" class="capitalize inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">log in</a>
                </div>
            @endif
        </div>

        <!-- Posts Container -->
        <div id="parent-container" class='w-full md:w-[600px] bg-[#151515] rounded-md mt-[50px]'>
            <div id="post-container"></div>
            <!-- Loader -->
            <div id='loader' class="hidden">
                @for ($i = 1; $i < 3; $i++)
                    <div class="post-loader border-b-1 border-gray-300 w-full">
                        <div class="post-header">
                            <div class="avatar"></div>
                            <div class="post-info">
                                <div class="line short"></div>
                                <div class="line medium"></div>
                            </div>
                        </div>
                        <div class="post-image"></div>
                        <div class="line full"></div>
                        <div class="line full"></div>
                        <div class="line half"></div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>

<section id='comment-section' class="hidden fixed top-0 w-full h-screen bg-black/30">
        {{-- comment box --}}
    <div id="comment-container" class="w-[400px] h-screen bg-[#3b3b3b] absolute right-0 transition-transform transform duration-500 ease-in-out translate-x-[400px]">
        <h1 id="cross" class="text-2xl bg-black/25 text-white font-light text-right p-3 capitalize cursor-pointer"><i class="fa-solid fa-xmark duration-150 hover:rotate-[50deg]"></i></h1>
        <div class="flex flex-col space-y-[20px] p-2 relative overflow-y-auto h-full">
           <div id="Comments-loader" class="space-y-[20px] hidden">
             @for ($i = 0; $i <= 5; $i++)
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
        <div id="comment-box" class="flex flex-col space-y-[20px] p-2 relative overflow-y-auto h-full">

        </div>
           </div>
        {{-- form --}}
<form id="comment-form" class="fixed bottom-0 p-2">
<div class="messageBox">
  <div class="fileUploadWrapper">
    <label for="file">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 337 337">
        <circle
          stroke-width="20"
          stroke="#6c6c6c"
          fill="none"
          r="158.5"
          cy="168.5"
          cx="168.5"
        ></circle>
        <path
          stroke-linecap="round"
          stroke-width="25"
          stroke="#6c6c6c"
          d="M167.759 79V259"
        ></path>
        <path
          stroke-linecap="round"
          stroke-width="25"
          stroke="#6c6c6c"
          d="M79 167.138H259"
        ></path>
      </svg>
      <span class="tooltip">Add an image</span>
    </label>
    <input type="file" id="file" name="file" />
  </div>
  <input required="" placeholder="Message..." type="text" id="messageInput" />
  <div id="loading" class="hidden justify-center w-full py-1 absolute left-[165px]">
            <div class="loading">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div>
            <div class="bar6"></div>
            <div class="bar7"></div>
            <div class="bar8"></div>
            <div class="bar9"></div>
            <div class="bar10"></div>
            <div class="bar11"></div>
            <div class="bar12"></div>
           </div>
           </div>
  <button id="sendButton" type="submit">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 664 663">
      <path
        fill="none"
        d="M646.293 331.888L17.7538 17.6187L155.245 331.888M646.293 331.888L17.753 646.157L155.245 331.888M646.293 331.888L318.735 330.228L155.245 331.888"
      ></path>
      <path
        stroke-linejoin="round"
        stroke-linecap="round"
        stroke-width="33.67"
        stroke="#6c6c6c"
        d="M646.293 331.888L17.7538 17.6187L155.245 331.888M646.293 331.888L17.753 646.157L155.245 331.888M646.293 331.888L318.735 330.228L155.245 331.888"
      ></path>
    </svg>
  </button>
</div>

</form>
    </div>
</section>


     <script src="{{asset('js/loadposts.js')}}"></script>
     <script src="{{asset('js/notify.js')}}"></script>
</body>
</html>