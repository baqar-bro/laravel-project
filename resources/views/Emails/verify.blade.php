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
    <div class="w-full h-screen flex justify-center items-center gap-1.5 bg-black text-white">
        <div class="p-5 border-1 border-gray-500 rounded-md text-center">
            <form action="{{ route('verification.send') }}" method="post">
                @if (session('message'))
                    <p class="mt-1 text-red-500 text-[12px] ml-1 text-center capitalize m-2.5">- {{ session('message') }} -</p>
                @endif
            <h1 class="capitalize text-center text-2xl">hey user</h1>
        <p class="capitalize text-xl mt-2">check your email you have recieved mail for verification</p>
        <p class="capitalize text-[13px] mt-1">did not recieve email ? <span>
            @csrf
            <button type="submit" class="text-red-500 underline capitalize bg-transparent cursor-pointer">click here</button>
            </span> to resend !</p></form>
        </div>
    </div>
</body>
</html>