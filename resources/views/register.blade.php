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
        <h1 class="capitalize text-3xl underline">register here </h1>
        <form action=" {{ URL('add') }} " method="POST" class="w-[500px] border border-gray-600 rounded-md p-9 flex flex-col gap-4">
            @csrf
             @if(session('user'))
                    <p class="mt-1 text-red-400 text-[12px] ml-1 text-center capitalize">- {{ session('user') }} -</p>
             @endif
            <div>
                <input type="text" placeholder="Enter your name ..." id='name' name='name' value="{{ old('name') }}" class="bg-black border border-gray-600 rounded-md p-2 w-full">
            @error('name')
                <p class="mt-1 text-red-400 text-[12px]">- {{ $message }}</p>
            @enderror
            </div>
           <div>
             <input type="email" placeholder="Enter your email ..." id='email' name='email' value="{{ old('email') }}" class="bg-black border border-gray-600 rounded-md p-2 w-full">
             @error('email')
                <p class="mt-1 text-red-400 text-[12px] ml-1">- {{ $message }}</p>
            @enderror
           </div>
            <div>
                <input type="password" placeholder="Create password ..." id='password' name='password' value="{{ old('password') }}" class="bg-black border border-gray-600 rounded-md p-2 w-full">
             @error('password')
                <p class="mt-1  text-red-400 text-[12px] ml-1">- {{ $message }}</p>
            @enderror
            </div>
            <div class="flex justify-center items-center gap-5 mt-5">
                <a href="{{ URL('/') }}" onclick="return confirm('Are you sure you want to cancel?');"
                class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">cancel</a>
                <button type="submit" class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">login</button>
            </div>
        </form>
    </div>
</body>
</html>