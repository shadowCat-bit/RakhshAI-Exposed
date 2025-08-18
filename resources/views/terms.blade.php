@extends('layouts.public', ['title' => 'قوانین و مقررات سامانه رخشای'])

@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "قوانین",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection

@section('content')
@include('layouts.header')

<div class="page-container about-us-page">
  <div class="container">
    <div class="row pt-5">
      <div class="col-12">
        <h1 class="text-center page-title">قوانین و مقررات</h1>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-4">
        <img src="{{asset('assets/images/main/rakhshai.jpg')}}" class="img-fluid rounded">
      </div>
      <div class="col-md-8 text-white">
        <p>
          تمام قوانین سامانه رخشای بر طبق قوانین جاری کشور می باشد و استفاده از این سامانه شامل پذیرش قوانین جاری
          کشور است.
        </p>
        <h2>
          حریم خصوصی
        </h2>
        <p>
          ما از اطلاعات شما به به هیچ وجه استفاده سوء نخواهیم کرد و اطلاعات شما را در اختیار شخص ثالثی قرار نخواهد گرفت تمام
          اطلاعات وارد شده توسط شما نزد ما توسط متد های روز رمزنگاری جهانی رمز گزاری می شود تا مانع از هک و نفوذ به اطلاعات شما
          شویم.
        </p>
        <h2>
          قوانین برگشت وجه
        </h2>
        <p>
          بعد از خرید پکیج ها امکان برگشت وجه وجود نخواهد داشت .
        </p>
      </div>
    </div>
  </div>
</div>
@include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
@endsection
  