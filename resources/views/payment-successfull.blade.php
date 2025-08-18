@extends('layouts.public', ['title' => 'پرداخت موفق | رخشای'])
@section('content')

@include('layouts.header')

<div class="page-container payment-status">

  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <i class="bi bi-check-circle-fill success-icon"></i>
            <h1 class="mt-3 success-payment-text">پرداخت شما با موفقیت انجام شد</h1>
            <p class="mt-4">سفارش شما با موفقیت پردازش شد.</p>
            <ul class="mt-4 payment-items">
                <li><strong>تعداد سکه:</strong> <span class="text-warning">{{$package->tokens}}</span></li>
                <li><strong>مبلغ:</strong> {{$package->price_text}}</li>
                <li><strong>شماره سفارش:</strong> {{$tr->track_id}}</li>
            </ul>
            <a href="{{url('/chat')}}" class="btn btn-success btn-lg mt-4 text-white">بازگشت به صفحه چت</a>
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