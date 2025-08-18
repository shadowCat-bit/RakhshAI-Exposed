@extends('layouts.public', ['title' => 'ورود به سامانه | رخشای'])
@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "ورود",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection
@section('content')

<!-- Header -->
{{--@include('layouts.header')--}}

<div class="main-inner auth-page-container">
    <main class="main-sec auth-page login-step" style="padding-bottom: 50px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-7 col-lg-5">
                    <div class="top-sec">
                        <a href="{{url('/')}}"><img width="160" src="{{asset('assets/images/main/logo-md.webp')}}"></a>
                        <h2 class="title">اولین دستیار و مدل هوش مصنوعی ایرانی</h2>
                    </div>
                    <div class="card text-white inner-card">
                        <div class="card-header text-center">
                            <h1 class="page-title">ورود به حساب کاربری</h1>
                        </div>
                        @if($errors->has('msg'))
                            <div class="alert alert-danger">{{$errors->first('msg')}}</div>
                        @endif
                        <div class="card-body">
                            <form action="{{route('login.process')}}" method="post" id="loginForm">
                                @csrf
                                <input type="hidden" name="recaptcha" id="recaptcha">
                                <div class="mb-4">
                                    <label for="mobile" class="form-label">شماره موبایل:</label>
                                    <input autofocus type="tel" class="form-control convert-to-en-num input-s" id="mobile" name="mobile" placeholder="09XXXXXXXXX" required>
                                </div>
                                <div class="mb-4 position-relative toggle-password">
                                    <label for="password" class="form-label">رمز عبور:</label>
                                    <input type="password" class="form-control pass-input convert-to-en-num input-s" id="password" name="password" minlength="4" required>
                                    <div class="visibility">
                                        <img width="24" src="{{asset('assets/images/icons/visible.svg')}}">
                                        <img class="d-none" width="24" src="{{asset('assets/images/icons/invisible.svg')}}">
                                    </div>
                                </div>
{{--                                <button type="submit" class="btn-gr style-5 btn-submit w-100 mt-3 mx-0">ورود</button>--}}
                                <button type="submit" class="btn-gr style-5 btn-submit w-100 mt-3 mx-0">
                                    <span class="submit-btn-text">ورود</span>
                                    <div class="spinner d-none">
                                        <div class="spinner-border text-light" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </button>
                                <a href="{{route('forgot-password.step1')}}" class="text-style-1 d-block w-100 mt-5 forget-pass-text">فراموشی رمز عبور</a>
                            </form>
                        </div>
                    </div>
                    <p class="mt-3 text-center bottom-link">حساب کاربری ندارید؟ <a href="{{url('auth/register')}}" class="text-style-1 decoration-none">ثبت نام کنید</a></p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner">
                        <a class="link-item" href="{{url('/')}}">صفحه اصلی</a>
                        <a class="link-item" href="{{url('/auth/register')}}">ثبت نام</a>
                        <a class="link-item" href="{{route('forgot-password.step1')}}">فراموشی رمز عبور</a>
                        <a class="link-item" href="{{url('/about-us')}}">درباره ما</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Footer -->
{{--@include('layouts.footer')--}}

<script src="{{asset('assets/js/jquery.js')}}"></script>
<!-- Bootstrap 5 JS dependencies -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Custom JavaScript -->
<script src="{{asset('assets/js/auth-v4.js')}}"></script>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'login'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script>

@endsection
