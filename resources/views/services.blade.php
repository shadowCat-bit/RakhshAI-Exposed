@extends('layouts.public', ['title' => 'خدمات توسعه دهندگان'])

@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "توسعه دهندگان",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection

@section('content')
@include('layouts.header')
<main class="page-container services-page versions-page">
    <div class="container py-5">
      <div class="text-center"><h1 class="page-title my-4">خدمات توسعه دهندگان</h1></div>
      <div class="row d-flex justify-content-center">
        <div class="col-12">
          <img class="img-fluid w-100" src="{{asset('assets/images/main/rakhshai-services.webp')}}" alt="خدمات توسعه دهندگان رخشای">
        </div>
        <div class="col-12">
          <div class="list-group api-inner">
            <div class="list-group-item list-group-item-action bg-transparent">
              <h2 class="text-white title-level1">سرویس API رخشای</h2>
              <p class="text-white">برنامه نویسان و توسعه دهندگان گرامی که قصد استفاده از بستر هوش مصنوعی در پروژه و کسب و کار خود دارند می توانند از خدمات و سرویس های  آنلاین و برخط رخشای(شرکت آریاهامان مهر پارسه)  از طریق سرویس API استفاده کنند.

              </p>

                {{-- <div>
                    <h4 class="text-white mt-5">سرویس مدل های اختصاصی زال پلاس</h4>
                    <h5>تعرفه آموزش مدل اختصاصی برای سرویس زال + </h5>
                    <div class="alert alert-dark w-100 text-right mt-4" role="alert" style="text-align: right; border: 1px solid goldenrod">
                        <p class="text-right">هر 1000 سوال چهار ملیون تومان برای آموزش اولیه مدل اختصاصی زال شما
                            <br>
                            <br>
                            1000 سوال اولیه برای آموزش مدل اختصاصی رایگان</p>

                    </div>
                </div> --}}

              <div class="row">
                <div class="col-12">
                  <div class="list-group">
                    <div class="list-group-item list-group-item-action bg-transparent">
                      <div class="d-flex w-100 justify-content-between">
                        <h3 class="title-level2">سرویس چت آنلاین</h3>
                        <small>نسخه 1.0.0 بتا</small>
                      </div>
                      <p class="mb-1">استفاده از خدمات پرسش و پاسخ رخشای با استفاده از متغیرهای سفارشی سازی شده.</p>
                      <div class="alert alert-dark text-left" role="alert">
                        <b class="text-left">https://api.rakhshai.com/chat/v1</b>
                      </div>
                      <table class="table table-dark table-home">
                        <thead>
                          <tr>
                            <th class="py-2 text-center" colspan="2">
                          مستندات</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>متغیر</td>
                            <td>توضیحات</td>
                          </tr>
                          <tr>
                            <td>engine</td>
                            <td>موتور پردازشی : Zal</td>
                          </tr>
                          <tr>
                            <td>question</td>
                            <td>متن پرسش</td>
                          </tr>
                          <tr>
                            <td>answer</td>
                            <td>متن پاسخ قبلی(برای گفتگوهای ادامه دار)</td>
                          </tr>
                          <tr>
                            <td>condition</td>
                            <td>قوانین برنامه نویس</td>
                          </tr>
                          <tr>
                            <td>limitation</td>
                            <td>محدودیت تعداد کلمات پاسخ</td>
                          </tr>
                          <tr>
                            <td>tone</td>
                            <td>لحن پاسخگویی</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div>
                  <div class="list-group">
                    <div class="list-group-item list-group-item-action bg-transparent">
                      <div class="d-flex w-100 justify-content-between">
                        <h3 class="mb-1 title-level2">سرویس پاسخ و تحلیل بر اساس منابع و شرایط مشتری</h3>
                        <small>نسخه 1.0.0 بتا</small>
                      </div>
                      <p class="mb-1">استفاده از خدمات پرسش و پاسخ رخشای با استفاده از متغیرهای سفارشی سازی شده بر اساس منابع اطلاعاتی خاص مشتری.</p>
                      <div class="alert alert-dark text-left" role="alert">
                        <b class="text-left">https://api.rakhshai.com/my-ai/v1</b>
                      </div>
                      <table class="table table-dark table-home">
                        <thead>
                          <tr>
                            <th class="py-2 text-center" colspan="2">
                          مستندات</span>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>متغیر</td>
                            <td>توضیحات</td>
                          </tr>
                          <tr>
                            <td>engine</td>
                            <td>موتور پردازشی : Zal</td>
                          </tr>
                          <tr>
                            <td>question</td>
                            <td>متن پرسش</td>
                          </tr>
                          <tr>
                            <td>answer</td>
                            <td>متن پاسخ قبلی(برای گفتگوهای ادامه دار)</td>
                          </tr>
                          <tr>
                            <td>condition</td>
                            <td>قوانین برنامه نویس</td>
                          </tr>
                          <tr>
                            <td>limitation</td>
                            <td>محدودیت تعداد کلمات پاسخ</td>
                          </tr>
                          <tr>
                            <td>tone</td>
                            <td>لحن پاسخگویی</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div>
                  <div class="list-group">
                    <div class="list-group-item list-group-item-action bg-transparent">
                      <div class="d-flex w-100 justify-content-between">
                        <h3 class="mb-1 title-level2">سرویس کاملا شخصی سازی شده</h3>
                        <small>نسخه پایدار</small>
                      </div>
                      <p class="mb-1">طراحی یک موتور پردازشی با هوش مصنوعی بر اساس نیاز مشتری.</p>
                      <div class="alert alert-dark text-left" role="alert">
                        <b class="text-left">https://api.rakhshai.com/your-name</b>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
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

