<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f9fafb;
    color: #333;
    padding: 20px;
  }

  h1 {
    color: #2c3e50;
    font-size: 24px;
  }

  p {
    font-size: 16px;
    line-height: 1.5;
    margin-top: 0;
    margin-bottom: 20px;
  }

  a {
    display: inline-block;
    background-color: #3490dc;
    color: white !important;
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 5px;
    font-weight: bold;
  }

  a:hover {
    background-color: #2779bd;
  }
</style>


</head>
<body>

    <h1>Hello, {{ $userdata['name'] }}</h1>
<p>You have verified your email {{ $userdata['email'] }}</p>
<a href="{{ route('reset.page', ['token' => $token, 'email' => $userdata['email']]) }}">
    Reset Password
</a>

</body>
</html>