<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title class="capitalize">user account</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
</head> 
<body>
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

        <!-- From Uiverse.io by david-mohseni --> 
        <div id="loading" class="flex justify-center items-center w-full h-screen">
            <div class="loader">
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

        <div id='account_not_found' class="flex-col gap-4 justify-center items-center w-full h-screen hidden">
            <h1 id='error_msg' class="capitalize text-3xl text-center text-white"></h1>
            <div class="flex gap-2">
                <a href="{{ route('splashpage') }}" class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">cancel</a>
                <a href="{{ route('user.account') }}" class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">create</a>
            </div>
        </div>
        
        <div id="show_account" class="flex-col justify-center items-center w-full h-screen p-5 hidden">
            <div class="flex flex-col border w-full md:w-[600px] h-screen overflow-y-auto rounded-md bg-[#2D2D2D] gap-[10px]">
            <h1 id='acc_name' class="text-center text-2xl text-white capitalize font-light p-2 border border-white border-t-0 border-l-0 border-r-0"></h1>
            <div class="flex center gap-[50px] p-5 text-white"><img id="profile_image" alt="profile-photo" class="w-[70px] h-[70px] object-cover rounded-full">
            <div class="flex justify-between items-center gap-[100px] font-extralight capitalize">
                <div id='post' class="flex flex-col text-center cursor-pointer">
                <p id="acc_post" class="text-[17px]">...</p>
                <p class="capitalize text-[15px] text-white">post</p>
            </div>
            <div id='follower' onclick="followerToggle()" class="flex flex-col text-center cursor-pointer">
                <p id="follower_count" class="text-[17px]">...</p>
                <p class="capitalize text-[15px] text-white">follower</p>
            </div><div id='following' onclick="followingToggle()" class="flex flex-col text-center cursor-pointer">
                <p id="following_count" class="text-[17px]">...</p>
                <p class="capitalize text-[15px] text-white">following</p>
            </div></div>
        </div>
            <div>
                <p id="about_acc" class="capitalize text-md text-white font-light ml-3">about</p>
            </div>
            <div class="p-3">
                <button id="edit" class="w-full py-1 capitalize font-light text-white rounded-md cursor-pointer border-1 border-sky-200">edit profile</button>
            </div>
            <div class="flex justify-between items-center gap-3 mt-[30px] px-[50px] md:px-[100px]">
                <button id="eye" class="py-1 px-[20px] capitalize font-light text-black bg-white rounded-md cursor-pointer text-xl duration-200 hover:scale-110"><i class="fa-solid fa-eye"></i></button>
                <button id="like" class="py-1 px-[20px] capitalize font-light text-black bg-white rounded-md cursor-pointer text-xl duration-200 hover:scale-110"><i class="fa-solid fa-heart"></i></button>
                <button id="bookmark" class="py-1 px-[20px] capitalize font-light text-black bg-white rounded-md cursor-pointer text-xl duration-200 hover:scale-110"><i class="fa-solid fa-bookmark"></i></button>
            </div>
            <div id='activity' class="text-white h-full">
                <h1 id="no-post" class="text-3xl capitalize text-white font-light text-center">no post</h1>
            </div>
        </div>
    </div>

    <div id='followers_account' class="w-[90%] sm:w-[300px] max-w-[90%] h-[200px] overflow-y-auto hidden flex flex-col justify-between items-center bg-[#2D2D2D] border rounded-md absolute top-[40%] left-1/2 transform -translate-x-1/2 z-50">
        <h1 class="capitalize text-[20px] text-center text-white font-light p-3">followers</h1>
    </div>
    <div id='followings_account' class="w-[90%] sm:w-[300px] max-w-[90%] h-[200px] overflow-y-auto hidden flex flex-col justify-between items-center bg-[#2D2D2D] border rounded-md absolute top-[40%] left-1/2 transform -translate-x-1/2 z-50">
        <h1 class="capitalize text-[20px] text-center text-white font-light p-3">followings</h1>
    </div>

    </section>

    <script>
       window.userAccountInfoUrl = "{{ route('user.account.info') }}";
   </script>

    <script src="{{ asset('js/account_info.js') }}">
           
    </script>

</body>
</html>