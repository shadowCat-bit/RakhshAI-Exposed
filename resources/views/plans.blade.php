@extends('layouts.public', ['title' => 'پلن قیمت ها | رخشای'])
@section('content')

@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "پلن قیمت ها",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection

@include('layouts.header')

<div class="page-container plans-page">
  <div class="container plans-sec">
    <div class="row">
      <div class="col-12 plans-top">
        <h1 class="text-center page-title">پلن های قیمتی رخشای</h1>
      </div>
    </div>
    <div class="row align-items-stretch pb-4">
      <div class="col-12 col-sm-6 col-md-6 col-lg-3 plan-item d-flex flex-grow-1">
        <div class="card text-center h-100">
          <div class="card-header">
            <h3 class="plan-title py-2">طرح سیاوش</h3>
            <img class="img-fluid" src="{{asset('assets/images/main/siavash.jpg')}}">
          </div>
          <div class="card-body">
            <p class="card-title">در این طرح کاربران جدیدی که در رخشای افتتاح حساب کنند به میزان 5 هزار سکه داریک دریافت میکنند و می توانند 5 هزار
            کلمه پاسخ یا 5 تصویر با هوش مصنوعی از رخشای دریافت کنند .</p>
            <h6 class="card-text">زمان سکه های داریک : همیشگی!</h6>
            <h2 class="pt-2 pb-2 free-plan-price">رایگان</h2>
            @guest
            <a href="{{url('auth/register')}}" class="btn btn-lg btn-warning">ثبت نام</a>
            @else
            <a href="#" class="btn btn-lg btn-warning disabled" disabled>استفاده شده</a>
            @endguest
          </div>
        </div>
      </div>
      @foreach ($plans as $plan)
          <div class="col-12 col-sm-6 col-md-6 col-lg-3 plan-item d-flex flex-grow-1">
            <div class="card text-center h-100">
              <div class="card-header">
                <h3 class="plan-title py-2">{{$plan->title}}</h3>
                <img class="img-fluid" src="{{asset('assets/images/main/' . $plan->image)}}">
              </div>
              <div class="card-body">
                <p class="card-title">
                  {{$plan->description}}
                </p>
                <h6 class="card-text">زمان سکه های داریک : همیشگی!</h6>
                <h2 class="pt-2 pb-2 plan-price">{{$plan->price_text}}</h2>
                <a href="{{route('packages.payment-method', $plan)}}" class="btn btn-lg btn-warning px-5">خرید</a>
              </div>
            </div>
          </div>
      @endforeach
    </div>
    <div class="row descriptions py-5">
      <h4>تعرفه استفاده از سامانه رخشای</h4>
      <div class="col-md-12">
        <table class="table table-dark table-home">
          <thead>
            <tr>
              <th class="py-2">
                <span class="d-block py-2 text-right">سرویس</span>
              </th>
              <th class="py-2">
                <span class="d-block py-2 text-right">تعرفه</span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>دستیار متنی(چت بات) زال نسخه 1</td>
              <td>هر کلمه پاسخ : <b>1</b> سکه داریک</td>
            </tr>
            <tr>
              <td>دستیار متنی(چت بات) زال نسخه 2</td>
                <td>هر کلمه پاسخ : <b>15</b> سکه داریک</td>
            </tr>
            <tr>
              <td>پردازش تصویر (تولید عکس) شهرزاد نسخه 1</td>
                <td>هر تصویر : <b>1000</b> سکه داریک</td>
            </tr>
            <tr>
                <td>پردازش تصویر (تولید عکس) شهرزاد نسخه 2</td>
                <td>هر تصویر : <b>4000</b> سکه داریک</td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
    <div class="row descriptions">
      <div class="col-12">
        <p class="text-right">
          شما به نسبت طرح خریداری شده سکه داریک "واحد پول درون برنامه ای به ازای پرداخت تومانی" دریافت می کنید.
          هر سکه داریک معادل تقریبی یک کلمه پاسخ و هر 1000 سکه داریک معادل 1 تصویر هوش مصنوعی رخشای به شما است.
        </p>
        <p class="text-right">
          زمانی که شما از رخشای سوال می پرسید ، رخشای سوال شما را پردازش می کند و هر پاسخی که به شما بدهد تعداد کلمات آن محاسبه و
          به ازای هر کلمه پاسخ یک سکه داریک از حساب شما کم می شود.
        </p>
        <p class="text-right">
          بعد از اتمام سکه های داریک شما باید مجدد سکه داریک خریداری کنید در صورت تمایل می توانید در هر زمان سکه داریک خریداری
          کنید و محدودیتی ندارد.
        </p>
        <p class="text-right">
          "داریک اولین واحد پولی ایرانی در دوره پرشکوه هخامنشی است"
        </p>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        برای انتخاب پلنی مناسب نیازهای خود به موارد زیر توجه کنید:
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
