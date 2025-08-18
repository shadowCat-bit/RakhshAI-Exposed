@extends('layouts.public', ['title' => 'تایید ثبت نام | رخشای'])
@section('content')

<!-- Header -->

<div class="main-inner auth-page-container">
    <main class="main-sec auth-page register-step-2" style="padding-bottom: 50px">
  <div class="container">
      <div class="row justify-content-center mt-5">
      <div class="col-sm-10 col-md-7 col-lg-5">
          <div class="top-sec">
              <a href="{{url('/')}}"><img width="160" src="{{asset('assets/images/main/logo-md.webp')}}"></a>
              <h2 class="title">اولین دستیار و مدل هوش مصنوعی ایرانی</h2>
          </div>
          <div class="card inner-card text-white">
          <div class="card-header text-center">
              <h1 class="page-title">تایید ثبت نام</h1>
          </div>
          @if($errors->has('msg'))
            <div class="alert alert-danger">{{$errors->first('msg')}}</div>
          @elseif(!is_null($waitTime))
            <div class="alert alert-warning">برای ارسال مجدد کد باید {{$waitTime}} ثانیه صبر کنید</div>
          @elseif($isCodeSend)
            <div class="alert alert-success">کد تایید با موفقیت ارسال شد</div>
          @endif
          <div class="card-body">
              <form action="{{route('register.process')}}" method="post" class="step2-register-form" id="loginForm">
                @csrf
                <input type="hidden" name="recaptcha" id="recaptcha">
                <input type="hidden"name="mobile" value="{{request('mobile')}}">
                <div class="mb-4">
                  <label for="mobile" class="form-label">لطفا پس از وارد کردن نام و رمز عبور خود، کد ارسال شده به شماره {{request('mobile')}} را وارد نمایید
                  <a href="javascript:void(0)" class="text-style-1 btn-edit-number">ویرایش شماره موبایل</a>
                  </label>
                </div>
                <div class="my-3">
                  <label for="username" class="form-label">اسم شما</label>
                  <input autocomplete="off" type="text" class="form-control input-s" id="username" name="username" minlength="3" required>
                </div>
                <div class="mb-3 position-relative toggle-password">
                  <label for="password" class="form-label mt-3">رمز عبور:</label>
                  <input autocomplete="off" type="password" class="form-control pass-input input-s convert-to-en-num" id="password" name="password" minlength="4" required>
                    <div class="visibility">
                        <img width="24" src="{{asset('assets/images/icons/visible.svg')}}">
                        <img class="d-none" width="24" src="{{asset('assets/images/icons/invisible.svg')}}">
                    </div>
                </div>

                  <label for="verify_code" class="form-label mt-3">کد تایید:
                      <span class="verify-explain">(ارسال شده به موبایل شما)</span>
                  </label>
                  <div class="input-group mb-3">
                                            <input type="text" class="form-control input-s convert-to-en-num" id="code" name="verify_code" placeholder="" maxlength="4" required>
{{--                      <div class="verify-code-inner">--}}
{{--                          <div class="code-box">--}}
{{--                              <input name='code' class='code-input' required/>--}}
{{--                              <input name='code' class='code-input' required/>--}}
{{--                              <input name='code' class='code-input' required/>--}}
{{--                              <input name='code' class='code-input' required/>--}}
{{--                          </div>--}}
{{--                      </div>--}}
                  </div>

                <div class="send-code-again">
                  <div id="countdown"></div>
                  <a id="new-code-button" href="{{url("auth/register/confirm?mobile=$mobile&send_code=yes")}}" class="text-style-1 decoration-none" type="button">ارسال مجدد کد</a>
                </div>

                <button type="submit" class="btn-gr style-5 btn-submit w-100 mt-3 mx-0">
                    <span class="submit-btn-text">تایید ثبت نام</span>
                    <div class="spinner d-none">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </button>
              </form>
          </div>
          </div>
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
                    <a class="link-item" href="{{url('/auth/login')}}">ورود</a>
                    <a class="link-item" href="{{route('forgot-password.step1')}}">فراموشی رمز عبور</a>
                    <a class="link-item" href="{{url('/about-us')}}">درباره ما</a>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>

<script src="{{asset('assets/js/jquery.js')}}"></script>
<!-- Bootstrap 5 JS dependencies -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Custom JavaScript -->
<script src="{{asset('assets/js/auth-v4.js')}}"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
 // Set the countdown time in seconds
 const countdownTime = {{$waitTime ?? 120}};

 // Get the countdown element from the DOM
 const countdownElement = document.getElementById('countdown');

 // Get the new code button element from the DOM
 const newCodeButtonElement = document.getElementById('new-code-button');

 // Start the countdown
 let timeLeft = countdownTime;
 const countdownInterval = setInterval(() => {
   timeLeft--;
   countdownElement.innerText = ` ${timeLeft} ثانیه`;

   // Show the new code button when the countdown is over
   if (timeLeft === 0) {
     clearInterval(countdownInterval);
     countdownElement.innerText = '';
     newCodeButtonElement.style.display = 'block';
   }
 }, 1000);
});
</script>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'reg_step2'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script>
@endsection
