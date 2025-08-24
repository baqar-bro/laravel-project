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
        <h1 class="capitalize text-3xl underline">create your cloud account </h1>
        <form action="{{ route('create.account') }}" method="post" enctype="multipart/form-data" class="w-[500px] border border-gray-400 rounded-md p-9 flex flex-col gap-5">
            @csrf
             @if($errors->any())
                    <ul>
                        @foreach ($errors as $error)
                            <li class="mt-1 text-red-400 text-[12px] ml-1 text-center capitalize">{{ $error }}</li>
                        @endforeach
                    </ul>
             @endif
             <div class="relative inline-block w-full">
            <label class="bg-black text-gray-500 px-[145px] py-2 border border-gray-600 w-full rounded cursor-pointer hover:border-white hover:text-white transition">
                     Upload your image
            <input type="file" name="image" id='image' class="absolute left-0 top-0 w-full h-full opacity-0 cursor-pointer" />
            </label>
            </div>
            <div>
                <input type="text" placeholder="Enter your name ..." id='name' name='name' 
                value="{{ old('name') }}" class="bg-black border border-gray-600 rounded-md p-2 w-full hover:border-white transition">
            @error('name')
                <p class="mt-1 text-red-400 text-[12px]">- {{ $message }}</p>
            @enderror
            </div>
            <div>
                <textarea name="about" id="about" cols="30" rows="5" placeholder="About yourself..." 
                class="bg-black border border-gray-600 rounded-md p-2 w-full hover:border-white transition">{{old('about')}}</textarea>
            </div>
            <div class="flex justify-center items-center gap-5 mt-5">
                <a href="{{ URL('/') }}" onclick="return confirm('Are you sure you want to cancel?');"
                class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">cancel</a>
                <button type="submit" class="bg-white px-5 py-1.5 rounded-md text-black duration-300 hover:scale-110 mt-2.5 capitalize">create</button>
            </div>
        </form>
    </div>
</body>
</html>