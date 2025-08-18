@extends('layouts.public', ['title' => 'تماس با ما | رخشای'])

@section('content')
@include('layouts.header')
<main class="page-container contact-us-page">
    <div class="container py-5">
      <div class="row d-flex justify-content-center">
        <div class="col-md-7">
          <div class="text-center"><h1 class="page-title">تماس با ما</h1></div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">ایمیل یا شماره موبایل</label>
            <input type="text" class="form-control" placeholder="">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">متن پیام</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <button class="btn btn-warning">ارسال پیام</button>
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

