@extends('layouts.public', ['title' => 'LLM زال پلاس | رخشای'])
@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "LLM زال پلاس | رخشای",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection
@section('content')
@include('layouts.header')
<div class="page-container zalplus-llm-page">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="top-card" style="background-image: url({{asset('assets/images/main/bg2.png')}})">
          <div class="inner" style="background-image: url({{asset('assets/images/main/bg-shape.webp')}})">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('layouts.footer')
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
@endsection

