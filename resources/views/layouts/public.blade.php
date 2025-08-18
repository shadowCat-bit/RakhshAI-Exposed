<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/images/main/fav.ico')}}">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/style-v22.css')}}">
    @yield('head')
    @include('layouts.schema')
    @include('layouts.google-analytics')
</head>

<body>
    @yield('content')
</body>

</html>
