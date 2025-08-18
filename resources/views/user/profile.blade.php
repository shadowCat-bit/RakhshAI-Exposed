<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>سامانه و دستیار هوش مصنوعی ایرانی رخشای</title>
  <link rel="icon" type="image/x-icon" href="{{asset('assets/images/main/fav.ico')}}">
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/dashboard-v18.css')}}">
  <meta name="csrf-token" content="{{csrf_token()}}">
  @include('layouts.google-analytics')
  @vite(['resources/js/app.js' , 'resources/css/app.css'])
</head>

{{-- {{var_dump($convs)}} --}}
<body class="chat-page v2 bg-dark text-white">
  <div id="app">
    <profile-component />
  </div>

  <!-- Bootstrap JS -->
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <!-- Custom JS -->
  <script src="{{asset('assets/js/dashboard.js')}}"></script>
</body>
</html>
