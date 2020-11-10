<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('swAuth/library/bootstrap/bootstrap.min.css') }}" crossorigin="anonymous">

    <title> @yield('title') </title>
</head>
<body>


@yield('content')


<script src="{{ asset('swAuth/library/plugins/jquery.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('swAuth/library/bootstrap/bootstrap.min.js') }}" crossorigin="anonymous"></script>
</body>
</html>
