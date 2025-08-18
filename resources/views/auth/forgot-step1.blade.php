@extends('layouts.public', ['title' => 'فراموشی رمز عبور | رخشای'])
@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "فراموشی رمز عبور",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection
@section('content')

<div class="main-inner auth-page-container">
    <main class="main-sec auth-page forget-step-1" style="padding-bottom: 50px">
  <div class="container">
      <div class="row justify-content-center mt-5">
      <div class="col-sm-10 col-md-7 col-lg-5">
          <div class="top-sec">
              <a href="{{url('/')}}"><img width="160" src="{{asset('assets/images/main/logo-md.webp')}}"></a>
              <h2 class="title">اولین دستیار و مدل هوش مصنوعی ایرانی</h2>
          </div>
          <div class="card inner-card text-white">
          <div class="card-header text-center">
              <h1 class="page-title">فراموشی رمز عبور</h1>
          </div>
          @if($errors->has('msg'))
            <div class="alert alert-danger">{{$errors->first('msg')}}</div>
          @endif
          <div class="card-body">
              <form action="{{route('forgot-password.step2')}}" method="get" id="loginForm">
                <input type="hidden" name="recaptcha" id="recaptcha">
                <input type="hidden" name="send_code" value="yes">
                <div class="mb-3">
                    <label for="mobile" class="form-label">شماره موبایل:</label>
                    <input autofocus type="tel" class="form-control input-s convert-to-en-num" id="mobile" name="mobile" placeholder="09XXXXXXXXX" required>
                </div>
                  <button type="submit" class="btn-gr style-5 btn-submit w-100 mt-3 mx-0">
                      <span class="submit-btn-text">ادامه</span>
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
                        <a class="link-item" href="{{url('/auth/register')}}">ثبت نام</a>
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

<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'forgotpass_step1'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script>
@endsection
