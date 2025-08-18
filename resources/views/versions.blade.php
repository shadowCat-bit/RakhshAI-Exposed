@extends('layouts.public', ['title' => 'نسخه های رخشای'])

@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "نسخه ها",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection

@section('content')
@include('layouts.header')
<main class="page-container versions-page">
    <div class="container py-5">
      <div class="text-center"><h1 class="page-title my-4">نسخه های رخشای</h1></div>
      <div class="row d-flex justify-content-center">
        <div class="col-md-6">
          <h2 class="title2 text-center my-3">پردازش متن <strong class="text-warning">زال</strong></h2>
          <div class="list-group">
            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">0.0.1</h5>
                <small>13 تیر 1401</small>
              </div>
              <p class="mb-1">نسخه آزمایشی محدود</p>
            </div>
            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">0.1.0</h5>
                <small>1 فروردین 1402</small>
              </div>
              <p class="my-2">نسخه آزمایشی عمومی</p>
              <ul>
                <li class="my-1"><small>پایداری ارتباط سیستم با IP های خارج از کشور</small></li>
                <li class="my-1"><small>اشکالات کمتر در چت ها و مکالمات با پیام های زیاد در یک مکالمه، نشانگر افزایش پیام ها است</small></li>
                <li class="my-1"><small>ارتباط بهتر با مخاطب با زبان فارسی (همگرایی) تا ۱۰ درصد</small></li>
                <li class="my-1"><small>ثبات بیشتر (تایم آپدیت) هنگام تایپ پاسخ توسط زال تا ۳۰ درصد</small></li>
                <li class="my-1"><small>رابط کاربری کلی بهبود یافته است</small></li>
                <li class="my-1"><small>اضافه شدن قسمت تنظیمات متن (فارسی و انگلیسی): اندازه متن – فاصله بین خطوط – ضخامت متن – فاصله بین کلمات – فاصله حروف</small></li>
                <li class="my-1"><small>پوسته حالت تیره و روشن – رابط کاربری</small></li>
                <li class="my-1"><small>بهبود عملکرد و پشتیبانی برای اتصال کاربران همزمان تا ۲۰٪</small></li>
                <li class="my-1"><small>بهبود حالت کاربر موبایل و دسترسی به امکانات حالت دسکتاپ + گزینه آپدیت دستی و حالت نمایش مکالمات در موبایل</small></li>
              </ul>
            </div>
            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">0.2.0</h5>
                <small>4 خرداد 1402</small>
              </div>
              <p class="mb-1">نسخه عمومی اولیه</p>
              <ul>
                <li class="my-1"><small>اضافه شدن لحن های اساطیری، کوچه بازاری، شاعرانه، عصبانی، عاشقانه و شوخ طبع به چت بات زال</small></li>
                <li class="my-1"><small>آشنایی زال با نام کاربر در طول گفتگو برای بهبود ارتباط شناختی</small></li>
                <li class="my-1"><small>امکان حذف تمامی گفتگوها به جز گفتگوهای پین شده</small></li>
                <li class="my-1"><small>بهبود رابط کاربری موبایل و دسکتاپ</small></li>
              </ul>
            </div>
            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">1.0.0 <span class="badge bg-warning rounded-pill text-dark">فعلی زال 1</span></h5>
                <small>29 مرداد 1402</small>
              </div>
              <p class="mb-1">نسخه پایدار اولیه</p>
              <ul>
                <li class="my-1"><small>Artificial Neural Networks افزایش و بهبود عملکرد تا نهایت منابع قابل استفاده در زال نسخه 1</small></li>
                <li class="my-1"><small>افزایش 70 درصدی منابع شناختی</small></li>
                <li class="my-1"><small>حل خطاهای شناختی در پردازش سوالات حوزه برنامه نویسی</small></li>
                <li class="my-1"><small>امکان کپی کردن پیام ها</small></li>
                <li class="my-1"><small>افزایش 1 سرور پردازش متنی برای سرعت بیشتر پاسخگویی زال</small></li>
              </ul>
            </div>
            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">2.0.0 <span class="badge bg-warning rounded-pill text-dark">فعلی زال 2</span></h5>
                <small>23 مهر 1402</small>
              </div>
              <p class="mb-1">نسخه آزمایشی عمومی زال 2</p>
              <ul>
                <li class="my-1"><small>افزودن شخصیت اختصاصی رشته های تخصصی به دستیار متنی زال</small></li>
                <li class="my-1"><small>افزایش 7 برابری خودآگاهی زال 2 نسبت به زال 1</small></li>
                <li class="my-1"><small>افزایش 20 برابری الگوریتم محاسباتی</small></li>
                <li class="my-1"><small>افزایش 3 سرور پردازش متنی به شبکه سروری رخشای</small></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <h2 class="title2 text-center my-3">پردازش تصویر <strong class="roxana-c">شهرزاد</strong></h2>
          <div class="list-group">
            <div class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">1.0.0 <span class="badge roxana-bg rounded-pill text-dark">فعلی</span></h5>
                <small>10 خرداد 1402</small>
              </div>
              <p class="mb-1">نسخه عمومی اولیه</p>
              <ul>
                <li class="my-1"><small>پشتیبانی از زبان فارسی</small></li>
                <li class="my-1"><small>آموزش دیده با فرهنگ شناختی ایرانی</small></li>
                <li class="my-1"><small>امکان نمایش تصاویر در بخش عمومی</small></li>
                <li class="my-1"><small>نگهداری و ویرایش دائمی تصاویر در قسمت داشبورد</small></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      </div>
    </main>
@include('layouts.footer')
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
@endsection

