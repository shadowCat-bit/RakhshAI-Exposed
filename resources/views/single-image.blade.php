@extends('layouts.public', ['title' => $img['title'] . ' | هوش مصنوعی شهرزاد'])

@section('head')
  @vite(['resources/js/app.js' , 'resources/css/app.css'])
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta property="og:title" content="تصویر تولید شده با هوش مصنوعی ایرانی شهرزاد | رخشای">
  <meta property="og:image" content="{{asset('assets/images/main/fav.ico')}}">
  <meta property='og:description' content='شهرزاد، دستیار تولید تصویر با هوش مصنوعی'/>
  <meta property='og:url' content='{{url()->full()}}' />

    <script type="application/ld+json">
      [
        @foreach ($img->img as $image)
        {
        "@context": "https://schema.org/",
        "@type": "ImageObject",
        "name": "{{$img['title']}}",
        "contentUrl": "{{$image['original']}}",
        "license": "https://rakhshai.com/terms",
        "acquireLicensePage": "https://rakhshai.com/faq",
        "creditText": "تصویر تولید شده با هوش مصنوعی ایرانی شهرزاد | رخشای",
        "uploadDate": "{{$img->created_at}}",
        "creator": {
          "@type": "Person",
          "name": "{{$img->user->name}}"
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
          "name": "Shahrzad explore",
          "item": "https://rakhshai.com/explore"
        },{
          "@type": "ListItem",
          "position": 2,
          "name": "{{$img['title']}}",
          "item": "{{url()->full()}}"
        }]
      }
      </script>
@endsection

{{-- {{dd($otherImg)}} --}}

@section('content')
  @include('layouts.header')
  <main class="page-container single-image-page" id="app">
    <single-image-component :images="{{json_encode($img)}}"></single-image-component>
    {{-- {{$otherImg->links('layouts.custom-pagination')}} --}}
  </main>

  @include('layouts.footer')
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.js')}}"></script>
  <script src="{{asset('assets/js/script.js')}}"></script>
@endsection

