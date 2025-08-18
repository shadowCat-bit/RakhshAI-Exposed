@extends('layouts.public', ['title' => 'چالش های رخشای'])

@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "چالش های رخشای",
      "item": "{{url()->full()}}"
    }]
  }
  </script>
@endsection

@section('content')
@include('layouts.header')

<div class="page-container challenege-page">
  <div class="container">
    <div class="row mt-5">
        <div class="col-md-7">
            <h1>اولین چالش رخشای</h1>
            <h2>ساخت تصویر با هوش مصنوعی شهرزاد 2</h2>
        </div>
        <div class="col-md-5">

        </div>
        <div></div>
    </div>
  </div>
</div>
@include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="{{asset('assets/js/script.js')}}"></script>
@endsection
  