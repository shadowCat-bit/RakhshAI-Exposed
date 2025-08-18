@extends('layouts.public', ['title' => 'پرداخت ناموفق | رخشای'])
@section('content')

@include('layouts.header')

<div class="page-container payment-status">

  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <i class="bi bi-x-circle-fill error-icon"></i>
            <h1 class="mt-3 fail-payment-text">پرداخت شما ناموفق بود</h1>
            <p class="mt-4">در پرداخت شما مشکلی پیش آمده است، لطفا مجددا تلاش کنید و یا با پشتیبانی تماس حاصل نمایید.</p>
            <p class="mt-4">در صورت کسر وجه مبلغ تا 72 ساعت آینده به حساب شما برگشت داده میشود.</p>
            <ul class="mt-4 payment-items">
              <li><strong>شماره سفارش:</strong> {{$tr->track_id}}</li>
            </ul>
            <a href="{{url('/')}}" class="btn btn-lg btn-danger mt-4">بازگشت به صفحه اصلی</a>
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