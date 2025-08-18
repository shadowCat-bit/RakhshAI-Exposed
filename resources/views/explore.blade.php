@extends('layouts.public', ['title' => 'عکس های ساخته شده با هوش مصنوعی شهرزاد'])
@section('head')
@vite(['resources/js/app.js' , 'resources/css/app.css'])
<meta name="csrf-token" content="{{csrf_token()}}">

  <script type="application/ld+json">
    [
      @foreach ($images as $image)
      {
      "@context": "https://schema.org/",
      "@type": "ImageObject",
      "name": "{{$image['title']}}",
      "contentUrl": "{{$image->img[0]['original']}}",
      "license": "https://rakhshai.com/terms",
      "acquireLicensePage": "https://rakhshai.com/faq",
      "creditText": "تصویر تولید شده با هوش مصنوعی ایرانی شهرزاد | رخشای",
      "uploadDate": "{{$image->created_at}}",
      "creator": {
        "@type": "Person",
        "name": "RakhshAI by Shahrzad"
       },
       "publisher": {
        "@type": "Organization",
        "name": "RakhshAI with Shahrzad",
        "logo": {
          "@type": "ImageObject",
          "url": "https://rakhshai.com/assets/images/main/logo.png"
        }
      },
      "copyrightNotice": "ساخته شده توسط سامانه رخشای نسخه شهرزاد"
    }
    @if (!$loop->last)
        ,
    @endif
    @endforeach
    ]
    </script>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
          "@type": "ListItem",
          "position": 1,
          "name": "عکس های ساخته شده شهرزاد",
          "item": "{{url()->full()}}"
        }]
      }
      </script>
@endsection
@section('content')
@include('layouts.header')
<main class="page-container explore-page" id="app">
  <explore-component :image_data="{{json_encode($images)}}"></explore-component>
  <div class="text-center" id="loading-explore-vue"><div class="loader-circule"></div></div>
  <div id="explore-paginate">{{$images->links('layouts.custom-pagination')}}</div>
</main>

@include('layouts.footer')
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
@endsection

