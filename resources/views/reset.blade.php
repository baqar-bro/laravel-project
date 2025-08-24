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
        <h1 class="capitalize text-3xl underline">user email </h1>
        <form action=" {{ route('reset.pass') }} " method="post"  class="w-[500px] border border-gray-600 rounded-md p-9 flex flex-col gap-3">
            @csrf
            <div>
                @if(session('user'))
                    <p class="mt-1 text-red-400 text-[12px] ml-1 text-center capitalize">- {{ session('user') }} -</p>
                @endif
            </div>
            <div>
                <input type="hidden" name='token' id='token' value='{{ $token }}'>
                <input type="hidden" name='email' id='email' value='{{ $email }}'>
            </div>
            <div>
              <input type="text" placeholder="Reset password ..." id='reset' name='reset_password' required class="bg-black border border-gray-600 rounded-md p-2 w-full">
              @error('password')
                <p class="mt-1  text-red-400 text-[12px] ml-1">- {{ $message }}</p>
              @enderror
            </div>
            <div>
                <input type="password" placeholder="Confirm password ..." required id='confirm_password' name='confirm_password' class="bg-black border border-gray-600 rounded-md p-2 w-full">
            </div>
            <div class="flex justify-center items-center gap-5 mt-5">
                <a href="{{ route('login') }}" onclick="return confirm('are you sure!')"
                 class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">cancel</a>
                <button type="submit" class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">reset</button>
            </div>
        </form>
    </div>
</body>
</html>