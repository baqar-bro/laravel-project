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
     <section>
        <div class="h-screen w-[100px] flex flex-col justify-between items-center text-white border fixed top-0 bottom-0 p-2 border-none">
            <div class="text-3xl p-3"><i class="fa-solid fa-cloud"></i></div>
            <div class="flex flex-col bg-transparent rounded-xl p-3 gap-5 shadow-lg w-16 items-center">
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

            <span class="absolute left-14 opacity-0 group-hover:opacity-100 bg-white text-black text-sm rounded px-2 py-1 shadow transition-opacity duration-300">
                {{ $item['label'] }}
            </span>
        </a>
    @endforeach
</div>
            <div>
              @if(Auth::check())
              <a href="{{URL('logout')}}"  class="text-3xl text-[#404040] p-3 duration-200 hover:opacity-100"
                 onclick="return confirm('Are you sure you want to logout?');"><i class="fa-solid fa-right-from-bracket"></i></a>
              @else
              
              @endif
            </div>
        </div>
        </div>
        

          <div id="parent-container" class='w-[600px] bg-[#151515] rounded-md mt-[50px]'>

            
             
        </div>
     </section>

     <script src="{{asset('js/notify.js')}}"></script>
</body>
</html>