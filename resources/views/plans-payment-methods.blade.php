@extends('layouts.public', ['title' => 'پرداخت | رخشای'])
@section('content')

@include('layouts.header')

<div class="page-container container payment-page">
  <div class="row py-4">
    <div class="col-md-4">
      <img class="img-fluid" src='{{asset("assets/images/main/{$tokenPackage->image}")}}' alt="نام بسته">
    </div>
    <div class="col-md-8 px-3">
      <h2 class="text-warning my-2">{{$tokenPackage->title}}</h2>
      <p>{{$tokenPackage->description}}</p>
      <p>قیمت: <span class="text-warning">{{$tokenPackage->price_text}}</span></p>
      <p>تعداد سکه ها: <span class="text-warning">{{$tokenPackage->tokens}} سکه</span></p>
      <p>مدت زمان استفاده: نامحدود</p>
    </div>
  </div>

  <form method="post" action="{{route('packages.purchase', $tokenPackage)}}">
    @csrf
    <div class="row mt-5 my-5">
      
      {{-- <div class="col-md-2">
        <div class="form-check custom-radio bank-radio">
          <input class="form-check-input custom-control-input" type="radio" name="payment_id" id="sepehr" value="2">
          <label class="form-check-label custom-control-label bg-white p-2 bank-item" for="sepehr">
            <img width="80" src="{{asset('assets/images/main/sepehr.jpg')}}" alt="sepehr">
          </label>
        </div>
      </div> --}}

      <div class="col-md-2">
        <div class="form-check custom-radio bank-radio">
          <input class="form-check-input custom-control-input" type="radio" name="payment_id" id="behpardakht" value="1" checked>
          <label class="form-check-label custom-control-label bg-white p-2 bank-item" for="behpardakht">
            <img width="80" src="{{asset('assets/images/main/behpardakht.png')}}" alt="behpardakht">
          </label>
        </div>
      </div>

      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-success rounded-3 px-5 my-4 py-2 my-3">پرداخت</button>
      </div>
    </div>
  </form>

  {{-- <form method="post" action="{{route('packages.purchase', $tokenPackage)}}">
    @csrf
    <input type="hidden" value="2" name="payment_id">
    <button type="submit" class="btn btn-warning px-5 my-4 py-2 my-3">پرداخت</button>
  </form> --}}

  {{-- <div class="row mt-5">
    <div class="col-md-12">
      <p>در صورت پرداخت ناموفق و کسر وجه، مبلغ پرداخت شده شده تا 48 ساعت آینده به حساب شما باز خواهد گشت.</p>
    </div>
  </div> --}}

</div>

@include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
@endsection
