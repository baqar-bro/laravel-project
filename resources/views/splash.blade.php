<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    /* Full-screen black overlay */
    #blackOverlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: black;
      z-index: 9999;
    }
  </style>
    </head>
<body class="bg-black">
    <section id='splash' class='bg-black flex justify-center items-center gap-3 w-full h-screen opacity-100'> 
    <h1 class="text-3xl capitalize text-white opacity-50">welcome to cloud</h1>
    <p class='text-2xl text-white'><i class="fa-solid fa-cloud"></i></p>
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script>
    $(document).ready(function(){
        $('#splash').fadeIn(1000);
    setTimeout(() => {
        window.location.href = "{{ route('welcome') }}";
        $('#splash').fadeOut(500);
    }, 3000); 
    })

   </script>
</body>
</html>