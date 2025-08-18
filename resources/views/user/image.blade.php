<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>سامانه و دستیار هوش مصنوعی ایرانی رخشای</title>
  <link rel="icon" type="image/x-icon" href="{{asset('assets/images/main/fav.ico')}}">
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/dashboard-v18.css')}}">
  <meta name="csrf-token" content="{{csrf_token()}}">
  @include('layouts.google-analytics')
  @vite(['resources/js/app.js' , 'resources/css/app.css'])
</head>

<body class="image-page text-white">
  <div id="app">
    <image-component 
        :server_images="{{json_encode($images)}}" 
        @if (!is_null($img)) :img="{{json_encode($img)}}" @endif 
        :user="{{json_encode($user)}}" 
        :tokens="{{json_encode($remainingTokens)}}" 
        :canusev2="{{json_encode($canUserUseV2)}}" 
    />
  </div>
  
  <!-- Bootstrap JS -->
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <!-- Custom JS -->
  <script src="{{asset('assets/js/dashboard.js')}}"></script>
</body>
</html>