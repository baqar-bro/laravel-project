<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
       <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="flex flex-col justify-center items-center w-full h-screen bg-black text-white gap-5">
        <h1 class="capitalize text-3xl underline">login here </h1>
        <form action=" {{ URL('auth') }} " method="post" class="w-[500px] border border-gray-600 rounded-md p-9 flex flex-col gap-3">
            @csrf
            <div>
                @if(session('user'))
                    <p class="mt-1 text-red-400 text-[12px] ml-1 text-center capitalize">- {{ session('user') }} -</p>
                @elseif (session('logout'))
                <p class="mt-1 text-red-400 text-[12px] ml-1 text-center capitalize">- {{ session('logout') }} -</p>
                @endif
            </div>
            <div>
              <input type="email" placeholder="Enter your email ..." id='email' name='email' value='{{ old('email') }}' required class="bg-black border border-gray-600 rounded-md p-2 w-full">
            </div>
           <div>
             <input type="password" placeholder="Enter your password ..." id='password' name='password' value='{{ old('password') }}' required class="bg-black border border-gray-600 rounded-md p-2 w-full">
             @if(session('pass'))
                <p class="mt-1 text-red-400 text-[12px] ml-1 text-center capitalize">- {{ session('pass') }} -</p>
                @endif
           </div>
            <div class="flex justify-between items-center">
                <p class=" text-gray-500 capitalize text-[13px]">don't have any <span class="underline text-white capitalize ml-1"><a href="{{URL('register')}}">account ?</a></span></p>
                <div class="flex justify-center items-center text-[13px] gap-1"><input type="checkbox" id='checkbox' name='remember' class=" cursor-pointer"><label for="checkbox">Remeber Me</label></div>
            </div>
            <div>
                <a href="{{route('forgot.pass')}}" class="underline text-white capitalize text-[13px]">forgot password ?</a>
            </div>
            <div class="flex justify-center items-center gap-5 mt-5">
                <a href="{{ URL('/') }}" class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">cancel</a>
                <button type="submit" class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">login</button>
            </div>
        </form>
    </div>
</body>
</html>