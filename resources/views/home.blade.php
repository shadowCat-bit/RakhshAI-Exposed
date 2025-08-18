@extends('layouts.public', ['title' => 'اولین دستیار و مدل هوش مصنوعی ایرانی | رخشای'])
@section('head')
@vite(['resources/js/app.js' , 'resources/css/app.css'])
<meta name="csrf-token" content="{{csrf_token()}}">
<link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/videojs.css')}}">
@endsection
@section('content')

<div>
<!-- Header -->
@include('layouts.header')

<main class="main @auth logged-in @endauth">

  <section>

  <div class="main-slider">
    <div id="slider">

      <div class="slider-inner">
        <div id="slider-content">
          {{-- <div class="meta">Species</div> --}}
          <h2 id="slide-title" class="slide-title">رخشای،اولین مدل <br>هوش مصنوعی ایرانی</h2>
          <span data-slide-title="0">رخشای،اولین مدل <br>هوش مصنوعی ایرانی</span>
          <span data-slide-title="1">مدل زبانی آفلاین <br> زال پلاس</span>
          <span data-slide-title="2">هوش مصنوعی تو <br> زال 3</span>
          {{-- <div class="meta">Status</div> --}}
          <div id="slide-status">دستیار متنی زال و تولید تصویر شهرزاد،فرصتی هیجان انگیز برای یادگیری و رشد!</div>
          <span data-slide-status="0">دستیار متنی زال و تولید تصویر شهرزاد،فرصتی هیجان انگیز برای یادگیری و رشد!</span>
          <span data-slide-status="1">ابزاری هوشمند برای تولید و پردازش متن‌های فارسی بدون نیاز به اینترنت، با سرعت و دقت بالا</span>
          <span data-slide-status="2">هوش مصنوعی خودت را طراحی کن و دنیای هوشمندت را به سلیقه خودت شکل بده</span>

          <div id="btn-box-slider">
            @guest
            <ul class="btn-box-slider">
                <li class="nav-item">
                    <a class="nav-link btn-2" href="{{url('auth/register')}}">ثبت نام</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-btn" href="{{url('auth/login')}}">ورود</a>
                </li>
            </ul>
            @else
            <ul class="btn-box-slider">
              <li class="nav-item">
                  <a class="nav-link btn-2" href="{{url('chat')}}">چت با زال</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-btn" href="{{url('image')}}">ساخت عکس با شهرزاد</a>
              </li>
          </ul>
            @endguest
          </div>
          <span data-slide-buttons="0">
            @guest
            <ul class="btn-box-slider">
                <li class="nav-item">
                    <a class="nav-link btn-2" href="{{url('auth/register')}}">ثبت نام</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-btn" href="{{url('auth/login')}}">ورود</a>
                </li>
            </ul>
            @else
            <ul class="btn-box-slider">
              <li class="nav-item">
                  <a class="nav-link btn-2" href="{{url('chat')}}">چت با زال</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-btn" href="{{url('image')}}">ساخت عکس با شهرزاد</a>
              </li>
          </ul>
            @endguest
          </span>
          <span data-slide-buttons="1">
            <ul class="btn-box-slider">
                <li class="nav-item">
                    <a class="nav-link btn-2" href="https://rakhshai.com/news/the-first-offline-persian-language-model-with-400-billion-parameters-zal-plus-llm/">بیشتر بدانید</a>
                </li>
            </ul>
          </span>
          <span data-slide-buttons="2">
            <ul class="btn-box-slider">
                <li class="nav-item">
                    <a class="nav-link btn-2" href="https://rakhshai.com/news/about-zal-3-ai/">بیشتر بدانید</a>
                </li>
            </ul>
          </span>
         
        </div>
      </div>
  
      <img class="slider-img-item" src="{{asset('assets/images/slider/slide1.webp')}}" />
      <img class="slider-img-item" src="{{asset('assets/images/slider/slide2.webp')}}" />
      <img class="slider-img-item" src="{{asset('assets/images/slider/slide3.webp')}}" />
  
      <div id="pagination">
        <button class="active" data-slide="0"></button>
        <button data-slide="1"></button>
        <button data-slide="2"></button>
      </div>
  
    </div>
  </div>

  @guest
  <h3 class="text-center mt-4 mb-3 demo-title">دمو و تست رایگان <span class="text-warning"> زال</span></h3>
  <div class="demo style2">
    <div class="mac-window">
      {{-- <div class="mac-window-header">
        <div><span class="window-title-demo">دمو</span><span class="window-title-account">حساب کاربری</span></div>

        <div class="mac-window-title">Rakhsh<span class="text-warning">AI</span></div>
        <div class="mac-window-buttons">
          <div class="mac-window-button red"></div>
          <div class="mac-window-button yellow"></div>
          <div class="mac-window-button green"></div>
        </div>
      </div> --}}
      <div class="mac-window-body" id="app">
        <lottie-player id="horse-animation" src="{{asset('assets/images/animations/horse.json')}}" background="transparent"
          speed=".7" style="width: 300px; height: 300px; position:absolute; top:100px;opacity:.4"></lottie-player>
        <div class="mac-input-inner scrollbar-container">
          <div class="textarea-container-home scrollbar-element">
              <public-chat-component :channel="{{json_encode($channel)}}" :messages="{{json_encode($messages)}}" :maxchatexecuted="{{json_encode($maxChatExecuted)}}"></public-chat-component>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endguest

</section>

<section class="new-image-sec">
  <div class="container new-image">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-sm-12 right-column">
        <h2 class="sec-title pt-2">پردازش تصویر با هوش مصنوعی شهرزاد</h2>

        <p class="mt-1 mb-4">شما هم دوست دارید خیالتان را به تصویر بکشید؟ پس اجازه دهید خیال واقعیت شود!</p>

        <ul class="btn-box">
          <li class="">
              <a class="btn-2" href="{{url('/image')}}">ساخت تصویر با شهرزاد</a>
          </li>
          <li class="">
              <a class="nav-link text-btn" href="{{url('explore')}}">گالری تصاویر شهرزاد</a>
          </li>
      </ul>

      </div>
      <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="thumb-inner">
        <div class="images-grid">
          <div class="grid-row">
            <a target="_blank" id="image-box-1" class="grid-item grid-item-2" href="https://rakhshai.com/explore/image/4ef157ed-bc7a-4873-9d29-a7760ba1e162">
              <img src="https://rakhshai.com/images/2024-01-29/0873dc22-b077-45b4-b7b7-50674d35215d6464-1706556087-thumbnail.jpg">
            </a>
            <a target="_blank" id="image-box-2" class="grid-item grid-item-1" href="http://rakhshai.com/explore/image/8e8e97dc-172b-4f97-b7ad-33dc8ad55e0d">
              <img src="https://rakhshai.com/images/2024-10-02/7db77d0a-0976-490a-8bcd-225092fa6d772045-1727891977-thumbnail.jpg">
            </a>
          </div>
          <div class="grid-row">
            <a target="_blank" id="image-box-3" class="grid-item grid-item-1" href="http://rakhshai.com/explore/image/376d8864-9ed0-4b5d-aa4a-5a95b3366a12">
              <img src="https://rakhshai.com/images/2024-09-30/c879fbf6-af58-404c-bc17-2fd8623d65e51-1727683275-thumbnail.jpg">
            </a>
            <a target="_blank" id="image-box-4" class="grid-item grid-item-3" href="https://rakhshai.com/explore/image/536e0ed7-3a95-467b-b3d2-784db1657d89">
              <img src="https://rakhshai.com/images/2024-05-16/025b992b-f3c7-4b93-bc06-5a329cdfad8b9536-1715868675-thumbnail.jpg">
            </a>
            <a target="_blank" id="image-box-5" class="grid-item grid-item-2" href="http://rakhshai.com/explore/image/67ab7d1c-a49e-40d5-8698-14c47f1f1e37">
              <img src="https://rakhshai.com/images/2024-09-10/5f063e05-59aa-478d-ab20-97793cda35082045-1725972080-thumbnail.jpg">
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="video-sec">
  <div class="container video-container">
    <div class="row video-row">
      <div class="col-lg-6 col-12 order-1 order-lg-0">
        <div class="video-inner">
          <video
          id="video-1"
          class="video-js"
          controls
          preload="none"
          vjs-16-9
          poster="https://rakhshai.com/news/wp-content/uploads/2023/10/rakhshai-cover-2.jpg"
          data-setup='{ "fluid" : true }'
        >
        <source src="https://rakhshai.com/news/wp-content/uploads/2023/10/Rakhshai.mp4" type="video/mp4" />
          {{-- <source src="MY_VIDEO.webm" type="video/webm" /> --}}
          <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
              >supports HTML5 video</a
            >
          </p>
        </video>
        </div>
      </div>
      <div class="col-lg-6 col-12 order-0 order-lg-1">
        <div class="video-info-inner">
          <div class="info info-left">
            <h3 class="title">رخشای چیست؟</h3>
            <p class="description">در این ویدئو، توضیحات جامعی را درباره هوش مصنوعی رخشای مشاهده خواهید کرد.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row video-row">
      <div class="col-lg-6 col-12">
        <div class="video-info-inner">
          <div class="info info-right">
            <h3 class="title">زال 3 رونمایی شد!</h3>
            <p class="description">با زال 3 هوش مصنوعی و دنیای خودت رو خلق کن</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <div class="video-inner">
          <video
          id="video-4"
          class="video-js"
          controls
          preload="none"
          vjs-16-9
          poster="https://rakhshai.com/news/wp-content/uploads/2024/11/Introduction_of_Zal_artificial_intelligence_3.webp"
          data-setup='{ "fluid" : true }'
        >
          <source src="https://rakhshai.com/news/wp-content/uploads/2024/11/Introduction-of-Zal-artificial-intelligence-3.mp4" type="video/mp4" />
          {{-- <source src="MY_VIDEO.webm" type="video/webm" /> --}}
          <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
              >supports HTML5 video</a
            >
          </p>
        </video>
        </div>
      </div>
    </div>
    <div class="row video-row">
      <div class="col-lg-6 col-12 order-0 order-lg-1">
        <div class="video-info-inner justify-content-start">
          <div class="info info-left">
            <h3 class="title">زال 2 رونمایی شد!</h3>
            <p class="description">افزایش 7 برابری خودآگاهی زال 2 نسبت به زال 1</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12 order-1 order-lg-0">
        <div class="video-inner">
          <video
          id="video-2"
          class="video-js"
          controls
          preload="none"
          vjs-16-9
          poster="https://rakhshai.com/news/wp-content/uploads/2023/10/zal2-cover.jpg"
          data-setup='{ "fluid" : true }'
        >
          <source src="https://rakhshai.com/news/wp-content/uploads/2023/10/Zal2.mp4" type="video/mp4" />
          {{-- <source src="MY_VIDEO.webm" type="video/webm" /> --}}
          <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
              >supports HTML5 video</a
            >
          </p>
        </video>
        </div>
      </div>
    </div>
    <div class="row video-row">
      <div class="col-lg-6 col-12">
        <div class="video-info-inner justify-content-start">
          <div class="info info-right">
            <h3 class="title">شهرزاد چیست؟</h3>
            <p class="description">در این ویدیو با سامانه پردازش تصویر شهرزاد آشنا خواهید شد.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <div class="video-inner">
          <video
          id="video-3"
          class="video-js"
          controls
          preload="none"
          vjs-16-9
          poster="https://rakhshai.com/news/wp-content/uploads/2023/10/shahrzad2.jpg"
          data-setup='{ "fluid" : true }'
        >
        <source src="https://rakhshai.com/news/wp-content/uploads/2023/10/shahrzad-info.mp4" type="video/mp4" />
          {{-- <source src="MY_VIDEO.webm" type="video/webm" /> --}}
          <p class="vjs-no-js">
            To view this video please enable JavaScript, and consider upgrading to a
            web browser that
            <a href="https://videojs.com/html5-video-support/" target="_blank"
              >supports HTML5 video</a
            >
          </p>
        </video>
        </div>
      </div>
    </div>


  </div>
</section>

<section class="features-sec">
  <div class="container">

    <div class="row py-5 row2">
      <div class="col-md-8">
        <div class="inner ">
          <h3 class="title">هوش مصنوعی و چت بات زال نسخه 1</h3>
          <p class="description">زال نسخه ۱ محیطی است که می توانید دوستی را انتخاب کنید که مناسب حال شماست با تفکری متفاوت</p>
          <div class="items">
            <ul >
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>دوستی با تفکر اساطیری</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>دوستی عاشق و با تفکری عاشقانه</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>دوستی با تفکر و لحن عصبانی که همیشه به دنبال تایید شما نیست</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>دوستی با تفکر شاعرانه که عاشق شعر و مشاعره است</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>دوستی صمیمی با لحن کوچه بازاری</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>دوستی شوخ طبع که همه چی را به شوخی می گیرد</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>هوش مصنوعی ایرانی که برای فرهنگ ایرانی آموزش دیده است</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="img-inner">
          <img src="{{asset('assets/images/main/zal-1.jpg')}}">
        </div>
      </div>
    </div>




    <div class="row py-5">
      <div class="col-md-4">
        <div class="img-inner">
          <img src="{{asset('assets/images/main/zal-features.jpg')}}">
        </div>
      </div>
      <div class="col-md-8">
        <div class="inner">
          <h3 class="title">هوش مصنوعی و چت بات زال نسخه 2</h3>
          <p class="description">زال تسخه ۲ متخصص همه فن حریفی است که در هر لحظه و ساعت از شبانه روز به صورت کامل در اختیار شما است. شخصیت های زال 2، هر کدام دارای یک مدل اختصاصی هستند که بر اساس تخصص مد نظر آموزش دیده و در حال یادگیری و رشد می باشد.</p>
          <div class="items">
            <ul>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/learning.svg')}}" alt="features icon"></span>یادگیری عمیق مبتنی بر الگوهای شناختی فرهنگی و ملی ایرانی</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/character.svg')}}" alt="features icon"></span>افزودن شخصیت اختصاصی رشته های تخصصی</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/awareness.svg')}}" alt="features icon"></span>افزایش 7 برابری خودآگاهی زال 2 نسبت به زال 1</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/algorithm.svg')}}" alt="features icon"></span>افزایش 20 برابری الگوریتم محاسباتی</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/customize.svg')}}" alt="features icon"></span>شخصی سازی تنظیمات نمایش متن</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/title.svg')}}" alt="features icon"></span>تغییر نام هر گفتگو</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/pin.svg')}}" alt="features icon"></span>پین کردن هر گفتگو</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/dark.svg')}}" alt="features icon"></span>حالت نمایش تیره و روشن</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>ذخیره سازی همیشگی گفتگوها</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
      <div class="characters-list">
          <h2 class="characters-title">شخصیت های چت بات زال 2</h2>
          <div class="row">
              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="27" src="{{asset('assets/images/icons/characters/default-o.svg')}}">
                      </div>
                      <h3 class="title">معمولی</h3>
                      <p class="subtitle">بدون هیچ سوگیری شناختی به سوالات شما پاسخ می دهد.</p>
                  </div>
              </div>
              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="27" src="{{asset('assets/images/icons/characters/psychologist-o.svg')}}">
                      </div>
                      <h3 class="title">روان شناس</h3>
                      <p class="subtitle">یک روان شناس تمام عیار که به تمامی علوم روانشناسی و روانشناختی دسترسی دارد و بدون هیچ قضاوتی پاسخگوی شماست.</p>
                  </div>
              </div>
              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="24" src="{{asset('assets/images/icons/characters/developer-o.svg')}}">
                      </div>
                      <h3 class="title">برنامه نویس</h3>
                      <p class="subtitle">یک برنامه نویس حرفه ای که به تمام زبان های برنامه نویسی مسلط است و در زمینه های دیباگ، آموزش و مشاوره به صورت تخصصی شما را همراهی می کند.</p>
                  </div>
              </div>
              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="26" src="{{asset('assets/images/icons/characters/language-teacher-o.svg')}}">
                      </div>
                      <h3 class="title">مدرس زبان</h3>
                      <p class="subtitle">یک مدرس و استاد باحوصله و خلاق که با جدیدترین متدهای آموزشی در دنیا آشناست و در یادگیری تمامی زبان های دنیا و تمامی سطوح آموزشی با شما همراه است.</p>
                  </div>
              </div>
              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="26" src="{{asset('assets/images/icons/characters/content-producer-o.svg')}}">
                      </div>
                      <h3 class="title">تولید کننده محتوا</h3>
                      <p class="subtitle">تولید محتوای متنی برای تمام رشته های مارکتینگ کاری پر مشغله است که این دستیار به بهترین روش و با خلاقیت و طبق استانداردهای روز مارکتینگ این مشکل را برطرف می کند.</p>
                  </div>
              </div>

              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="27" src="{{asset('assets/images/icons/characters/seo-o.svg')}}">
                      </div>
                      <h3 class="title">متخصص سئو</h3>
                      <p class="subtitle">بهینه سازی سامانه و کسب و کار شما برای تمامی سکوها و شبکه های اجتماعی و موتورهای جستجو، چه از لحاظ فنی چه استراتژی تماما توسط این متخصص انجام خواهد شد.</p>
                  </div>
              </div>
              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="24" src="{{asset('assets/images/icons/characters/history-o.svg')}}">
                      </div>
                      <h3 class="title">تاریخ پژوه</h3>
                      <p class="subtitle">یک ماجراجوی تمام عیار که در تمام برهه های تاریخ زندگی کرده است و می تواند وقایع تاریخی را برای شما مرور و تحلیل کند.</p>
                  </div>
              </div>
              <div class="col-md-3 item2">
                  <div class="character-inner">
                      <div class="icon">
                          <img width="26" src="{{asset('assets/images/icons/characters/financial-o.svg')}}">
                      </div>
                      <h3 class="title">مشاور مالی</h3>
                      <p class="subtitle">یکی از حساس ترین مسائل زندگی که در روند و رشد زندگی تاثیر زیادی دارد مسائل مالی است که شما می توانید با الگوریتم های هوش مصنوعی آن را بهینه کرده و رشد دهید.</p>
                  </div>
              </div>

          </div>
      </div>
      


      <div class="container">
        <div class="row py-5">
          <div class="col-md-4">
            <div class="img-inner">
              <img src="{{asset('assets/images/main/zal-3.jpg')}}">
            </div>
          </div>
          <div class="col-md-8">
            <div class="inner">
              <h3 class="title">هوش مصنوعی تو - هوش مصنوعی و چت بات زال نسخه 3</h3>
              <p class="description">این نسخه جدید با قابلیت‌های منحصربه‌فردی که تاکنون در دسترس نبوده‌اند، تجربه‌ای نوین از تعامل با هوش مصنوعی را به شما ارائه می‌دهد. مهم‌ترین و شگفت‌انگیزترین ویژگی زال ۳.۰ این است که شما می‌توانید هوش مصنوعی اختصاصی خود را بسازید، آن را توسعه دهید و به دلخواه تغییر دهید تا بهترین دستیار متنی برای نیازهای خود را داشته باشید. این پلتفرم بی‌نظیر به شما امکان می‌دهد یک دستیار هوش مصنوعی با توانایی‌های منحصربه‌فرد خلق کنید که با گذر زمان هوشمندتر و دقیق‌تر می‌شود. آموزش دیده با مدل و فرهنگ ایرانی</p>
              <div class="items">
                <ul>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/learning.svg')}}" alt="features icon"></span>قابلیت انتخاب نام و تصویر برای هوش مصنوعی تو </li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/character.svg')}}" alt="features icon"></span>با توضیحات در حد 10,000 کلمه می توانی هوش مصنوعی خود را خلق کنی</li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/awareness.svg')}}" alt="features icon"></span>هوش مصنوعی تو همانگونه فکر می کند که تو می خواهی</li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/algorithm.svg')}}" alt="features icon"></span>بیشترین هماهنگی با فرهنگ ایرانی به دلیل استفاده از مدل ایرانی تحلیل متن </li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/customize.svg')}}" alt="features icon"></span>خلق شخصیت خیالی - خلق دنیای خیالی - خلق موجودات خیالی - تحلیل داده‌های اختصاصی</li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/title.svg')}}" alt="features icon"></span>تغییر نام هر گفتگو</li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/pin.svg')}}" alt="features icon"></span>پین کردن هر گفتگو</li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/dark.svg')}}" alt="features icon"></span>حالت نمایش تیره و روشن</li>
                  <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>ذخیره سازی همیشگی گفتگوها</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>



    <div class="row py-5 row2">
      <div class="col-md-8">
        <div class="inner">
          <h3 class="title">هوش مصنوعی ایرانی پردازش تصویر و تولید تصویر شهرزاد</h3>
          <p class="description">شهرزاد خود یک اسطوره است که می تواند تمام آن چه در ذهن شما می گذرد را با استفاده از الگوریتم های هوش مصنوعی و نمادهای فرهنگی به تصویر بکشد.</p>
          <div class="items">
            <ul>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/learning.svg')}}" alt="features icon"></span>یادگیری عمیق مبتنی بر الگوهای شناختی فرهنگی و ملی ایرانی</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/customize.svg')}}" alt="features icon"></span>شخصی سازی تولید تصویر برای ارتباط شناختی بهتر</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/size.svg')}}" alt="features icon"></span>شخصی سازی تعداد و اندازه تصویر</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/command.svg')}}" alt="features icon"></span>دستورات اختصاصی برای ساخت تصاویر دقیق تر</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/pin.svg')}}" alt="features icon"></span>پین کردن هر تصویر</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/explore.svg')}}" alt="features icon"></span>بخش عمومی برای تمایش تصاویر تولید شده کاربران</li>
              <li><span class="icon"><img width="18" src="{{asset('assets/images/icons/features/store.svg')}}" alt="features icon"></span>ذخیره سازی همیشگی تصاویر</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="img-inner">
          <img src="{{asset('assets/images/main/shahrzad-features.jpg')}}">
        </div>
      </div>
    </div>

    <div class="usages">
      <div class="usages-inner">
          <h3 class="usages-title">قابل استفاده برای انواع حرفه ها و کسب و کار ها</h3>
          <ul class="home-usages owl-carousel owl-theme">
              <li>روانشناسان</li>
              <li>برنامه نویسان</li>
              <li>تولیدکنندگان محتوا</li>
              <li>تحلیلگران داده</li>
              <li>پزشکان</li>
              <li>مترجمان</li>
              <li>مدیران پروژه</li>
              <li>معلمان</li>
              <li>دانشجویان</li>
              <li>دانش آموزان</li>
              <li>فعالین بازارهای مالی</li>
              <li>هنرمندان</li>
          </ul>
      </div>
  </div>
  <div class="languages-support">
      <div class="languages-inner">
          <div class="row h-100">
              <div class="col-md-6 h-100 right-col">
                  <h3 class="title">
                      زبان ها به یک نقطه می رسند
                  </h3>
                  <p class="desc">هوش مصنوعی رخشای به تمام زبان های دنیا گوش می دهد و از مرزهای زبانی فراتر می رود تا با الفبای گفتار و فرهنگ های متعدد دنیا در ارتباط باشد</p>
                  <a href="{{url('/chat')}}" class="btn-gr style-1 mt-4">گفتگو با زال 2</a>
              </div>
              <div class="col-md-6 h-100 left-col">
                  <div class="inner">

                  </div>
              </div>
          </div>
      </div>
  </div>



  </div>
</section>

<section class="free-coins-sec text-light">
  <div class="container py-5 h-100">
    <div class="row justify-content-center py-5 h-100">
      <div class="col-md-6 text-center h-100">
        <div class="main-text"><strong class="text-warning">5,000</strong> <strong data-bs-toggle="tooltip" data-bs-placement="top" title="واحد پول هخامنشی">سکه داریک</strong>
          <br>
          معادل <b>5,000</b> کلمه پاسخ
          /
           <b>5</b> تصویر
          <br>
           <strong class="text-warning">رایگان</strong> برای کاربران جدید</div>

          <p class="z-index-top position-relative mt-5"><span class="text-warning">داریک</span> واحد پول دوره پرشکوه هخامنشیان است که ما در رخشای <strong>تنها به عنوان واحد درون برنامه ای</strong> برای شمارش استفاده می کنیم و شما می توانید با این واحد درون برنامه ای پاسخ دریافت کنید و یا به ازای خدمات دیگر ، پرداخت درون برنامه ای داشته باشید  .
            <br>
<br>
<br>
تنها راه خرید داریک چیست  ؟
<br>
شما در قسمت <a class="decoration-none" href="{{url('plans')}}">پکیج ها </a> می توانید به صورت پکیجی ،داریک خریداری کنید (به صورت تومان)  و از خدمات ما استفاده کنید .
          </p>

        <div class="text-center auth-container py-5">
          @guest
          <a href="{{url('auth/register')}}" class="btn-gr style-2 register-btn my-3">ثبت نام</a>
          @endguest
          <a href="{{url('chat')}}" class="btn-gr style-2 chat-btn my-3">چت با زال</a>
          @guest
          <a href="{{url('auth/login')}}" class="btn-gr style-2 mx-2 login-btn my-3">ورود</a>
          @endguest
          <a href="{{url('plans')}}" class="btn-gr style-2 register-btn my-3">خرید پکیج</a>
        </div>
        <div class="free-coin-img">
          <img class="rakhshai-coin-img" src="{{asset('assets/images/main/rakhshai-coins.webp')}}" alt="سکه رایگان رخشای">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="description-sec">
  <div class="container description-inner">
      <div class="box">
          <div class="inner2">
              <div class="row justify-content-center">
                  <div class="col-md-9 text-center">
                      <p>
                          من “رخشای” مخفف رخش ای آی اولین مدل هوش مصنوعی ایرانی هستم که با استفاده از توسعه اختصاصی موتور پردازش متنی زبان طبیعی با نام زال برای جمع آوری دیتاهای متنی و تحلیل آن در اول فروردین ماه خورشیدی شروع به کار کرده ام.
                      </p>
                      <p>
                          وظیفه من یک دستیار هوشمند بودن برای تمام کسب و کار های ایرانی است که دوست دارند محیط کسب و کار خود را با معیار های اولیه هوش مصنوعی افزایش دهند .
                      </p>
                      <a class="text-warning decoration-none z-index-top position-relative" href="{{url('about-us')}}">بیشتر بدانید...</a>
                  </div>
              </div>
          </div>
          <div class="top-skew"></div>
      </div>

      <div class="faq home-faq">
          <div class="row d-flex justify-content-center">
              <div class="col-md-8">
                  <div class="accordion" id="accordionExample">
                      <h2></h2>
                      <div class="accordion-item">
                          <h3 class="accordion-header" id="heading0">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse0"
                                      aria-expanded="true" aria-controls="collapse0">
                                  هوش مصنوعی چیست ؟
                              </button>
                          </h3>
                          <div id="collapse0" class="accordion-collapse collapse" aria-labelledby="heading0">
                              <div class="accordion-body">
                                  هوش مصنوعی به مجموعه ای از تکنولوژیها و الگوریتمهایی گفته میشود که برای تقلید قابلیتهای ذهن انسان با استفاده از محاسبات وجود دارد. به طور دقیق تر هوش مصنوعی در واقع تلاش برای ساخت دستگاهی است که مانند انسان بتواند حل مسائلی را که برای یک انسان پیچیده نیست، انجام دهد. در این راستا از تکنولوژیهایی مانند یادگیری عمیق، شبکه های عصبی و الگوریتم های یادگیری تقویتی استفاده میشود. در زمینه های مختلفی از جمله پردازش زبان طبیعی، بینایی ماشین و بازیابی اطلاعات از این تکنولوژی ها استفاده میشود.
                              </div>
                          </div>
                      </div>
                      <div class="accordion-item">
                          <h3 class="accordion-header" id="heading01">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapse01" aria-expanded="false" aria-controls="collapse01">
                                  هوش مصنوعی ایرانی رخشای چیست ؟
                              </button>
                          </h3>
                          <div id="collapse01" class="accordion-collapse collapse" aria-labelledby="heading01">
                              <div class="accordion-body">
                                  رخشای یک هوش مصنوعی ایرانی است که توسط شرکت آریا هامان مهر پارسه در حال توسعه است. این هوش مصنوعی به منظور دستیابی به یک سیستم هوشمند و نزدیک به انسان با تمرکز بر زبان فارسی و فرهنگ ایرانی طراحی شده است. شرکت آریا هامان مهر پارسه در حال حاضر در ایران یکی از اولین شرکتهایی است که در زمینه طراحی هوش مصنوعی و پردازش زبان فارسی فعالیت میکند و زحمات بسیاری را برای توسعه رخشای انجام داده است.
                              </div>
                          </div>
                      </div>
                      <div class="accordion-item">
                          <h3 class="accordion-header" id="heading990">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapse990" aria-expanded="false" aria-controls="collapse990">
                                  کاربرد هوش مصنوعی در شاخه هایی مثل تولید محتوا چیست ؟
                              </button>
                          </h3>
                          <div id="collapse990" class="accordion-collapse collapse" aria-labelledby="heading990">
                              <div class="accordion-body">
                                  هوش مصنوعی به طور گسترده در تولید محتوا به کار گرفته میشود و برای بهبود ضریب بهره وری در این زمینه، الگوریتم ها و مدل هایی برای تولید محتوای هوشمند به کمک هوش مصنوعی طراحی شده است. برخی از موارد کاربردی هوش مصنوعی در تولید محتوای دیجیتال شامل:
                                  <br>
                                  1. تحلیل داده ها و پیشبینی رفتار مخاطبان
                                  <br>
                                  2. ساخت آگهی های هدفمند
                                  <br>
                                  3. ایجاد خلاصه ی خودکار (Auto Summarizing) متون بلند
                                  <br>
                                  4. خودکارسازی فرآیند تهیه و ویرایش محتوای ویدیویی
                                  <br>
                                  5. تولید خودکار محتوای صوتی، متنی و تصویری
                                  <br>
                                  6. پردازش زبان طبیعی جهت تعامل با مشتریان
                                  <br>
                                  7. دسته بندی کردن محتواها و پیشنهاد محتوای مناسب
                                  در کل، با استفاده از هوش مصنوعی میتواند تولید محتوای بهتر، سریعتر و با کیفیت بالاتری در دنیای دیجیتال امکانپذیر شود.
                              </div>
                          </div>
                      </div>
                      <div class="accordion-item">
                          <h3 class="accordion-header" id="heading991">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                      data-bs-target="#collapse991" aria-expanded="false" aria-controls="collapse4">
                                  هوش مصنوعی ایرانی در چه شاخه هایی قابلیت استفاده دارد؟
                              </button>
                          </h3>
                          <div id="collapse991" class="accordion-collapse collapse" aria-labelledby="heading991">
                              <div class="accordion-body">
                                  برنامه نویسان ، تولیدکنندگان محتوا ، تحلیلگران داده ، پزشکان ، مترجمان ، مدیران پروژه ، معلمان ، دانشجویان ، دانش آموزان ، روانشناسان و ...
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>





<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5 text-white">سکوی توسعه دهندگان هوش مصنوعی ایرانی رخشای</h2>
    <div class="row g-4">
      <!-- تک کارت سراسری -->
      <div class="col-12">
        <div class="card custom-card h-100 text-center">
          <img src="{{asset('assets/images/logo-dev.png')}}"
               class="img-fluid mx-auto"
               style="max-height:85px; filter: grayscale(100%);"
               alt="Rinotex">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Rakhshai Web API</h5>
            <p class="card-text flex-grow-1">
              ما در سکوی توسعه‌دهندگان هوش‌مصنوعی رخشای مستقر شده‌ایم که دسترسی سریع و امن به مجموعه‌ای از ابزارها و استخر پردازش داده‌ی بومی و ایرانی  فراهم می‌کند.               معماری توزیع‌شده‌ی ما امکان پردازش آنی داده‌ها را میسر می‌سازد و امنیت سرویس با رمزنگاری  و کنترل دسترسی پیشرفته تضمین شده است. 
            </p>
            <p class="card-text flex-grow-1">
              داشبورد گزارش زنده، پشتیبانی ۲۴/۷ و SLA آپتایم ۹۹٪، تجربه‌ای قابل‌اعتماد برای توسعه‌دهندگان ارائه می‌دهد و صدور کلید و توکن امن API دسترسی به سرویس را به ساده‌ترین شکل ممکن امکان‌پذیر می‌کند.               در بخش مدل‌ها، در نسخه اولیه موتور «زال» - iran-llm-zal با توان پردازش تا ۲۰٬۰۰۰ کلمه، API استریم و حفظ زمینه‌ی دیالوگی در دسترس است و مدل داستان‌سرایی «شهرزاد» نیز به‌زودی عرضه خواهد شد. 
            </p>
            <b class="card-text flex-grow-1">
              با استفاده از این سرویس میتوانید زیرساخت شرکت یا مجموعه خود را به هوش مصنوعی ایرانی خود مجهز کنید .
            </b><p></p>
            <a href="https://developer.rakhshai.com/"
               class="btn-gr btn-o-style-4 p-2">
              ورود به پنل توسعه دهندگان
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>





{{-- <section class="tips-section">
  <div class="container py-5">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12 col-12">
        <div class="inner">
          <img src="">
          <h3></h3>
          <p></p>
        </div>
      </div>
    </div>
  </div>
</section> --}}
<section class="logos-carousel-sec py-5">
  <div class="container">
    <h3 class="text-center mb-2">همکاران و مدل‌های اختصاصی <strong>زال‌پلاس</strong></h3>
    <p class="text-center mb-4">شرکت‌ها و مدل‌هایی که در تحقیق و توسعه هوش مصنوعی با ما همکاری می‌کنند.</p>
    
    <div class="owl-carousel logos-carousel">
      
      <div class="item text-center">
        <img src="{{asset('assets/images/partners/ariakeshavarz.webp')}}" alt="آریا کشاورز">
        <h6 class="mt-2 mb-0">شرکت آریاکشاورز</h6>
        <small class=" d-block">حوزه کشاورزی</small>
      </div>
      <div class="item text-center">
        <img src="{{asset('assets/images/partners/med.webp')}}" alt="مرکز رشد سلامت">
        <h6 class="mt-2 mb-0">مرکز رشد و نوآوری سلامت</h6>
        <small class=" d-block">حوزه پزشکی و سلامت</small>
      </div>
      <div class="item text-center">
        <img src="{{asset('assets/images/partners/aria-hoosh.webp')}}" alt="آریایی اندیش">
        <h6 class="mt-2 mb-0">آریایی اندیش هوشمند</h6>
        <small class=" d-block">حوزه روانشناسی</small>
      </div>
      <div class="item text-center">
        <img src="{{asset('assets/images/models/baghyar.png')}}" alt="باغیار">
        <h6 class="mt-2 mb-0">باغیار</h6>
        <small class=" d-block">مدل کشاورزی پسته</small>
      </div>
      <div class="item text-center">
        <img src="{{asset('assets/images/partners/utopia.webp')}}" alt="اتوپیا">
        <h6 class="mt-2 mb-0">اتوپیا</h6>
        <small class=" d-block">مدل روانشناسی</small>
      </div>
      <div class="item text-center">
        <img src="{{asset('assets/images/partners/sepehr2.png')}}" alt="سپهر">
        <h6 class="mt-2 mb-0">سپهر</h6>
        <small class=" d-block">هوش پزشکی (آفلاین)</small>
      </div>
      
    </div>
  </div>
</section>

<style>
.logos-carousel .item img {
  width: 80px;
  height: 80px;
  object-fit: contain;
  filter: grayscale(100%);
  transition: filter .3s;
  margin: 0 auto;
}
.logos-carousel .item img:hover {
  filter: none;
}


</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link  href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
$(document).ready(function(){
  $('.logos-carousel').owlCarousel({
    loop: true,
    margin: 20,
    autoplay: true,
    autoplayTimeout: 2500,
    autoplayHoverPause: true,
    rtl: true,              
    responsive: {
      0:   { items: 2 },   
      576: { items: 3 },    
      768: { items: 4 },    
      992: { items: 5 },    
      1200:{ items: 6 }     
    }
  });
});
</script>







<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5 text-white">رخشای در نیم نگاه</h2>
    <div class="row g-4">
      
      <div class="col-md-4">
        <div class="card custom-card h-100 text-center">
          <img src="{{asset('assets/images/awards/rinotex.svg')}}" 
               class="img-fluid  mx-auto " style="max-height:85px; filter: grayscale(100%);" alt="Rinotex">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">جوایز کسب‌شده</h5>
            <p class="card-text flex-grow-1">
              ۸ ماه پس از رونمایی عمومی، رخشای اولین هوش مصنوعی ایرانی منتخب در حوزه‌ی نوآوری و فناوری اطلاعات و نرم‌افزارهای رایانه‌ای رینوتکس ۲۰۲۳ تبریز شد.
            </p>
            <a href="https://rakhshai.com/news/?p=356" class="btn-gr btn-o-style-4 p-2">مشاهده بیشتر</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card custom-card h-100 text-center">
          <img src="{{asset('assets/images/card/contract.png')}}" 
          class="img-fluid mt-2 mb-3 mx-auto" style="max-height:50px;" alt="Rinotex">
          <div class="card-body d-flex flex-column">
            <i class="bi bi-file-earmark-text-fill"></i>
            <h5 class="card-title">سند ملی هوش مصنوعی</h5>
            <p class="card-text flex-grow-1">
              تدوین و ابلاغ سند ملی با هدف قرار گرفتن ایران در میان ۱۰ کشور پیشرو تا سال ۱۴۱۲.
            </p><p><b>رخشای در چشم‌انداز این مسیر به کدام سو می رود ؟ </b></p>
            <a href="https://rakhshai.com/news/the-role-of-artificial-intelligence-in-the-future-of-iran-a-review-of-the-national-document-of-artificial-intelligence-and-prospects/" 
               target="_blank" class="btn-gr btn-o-style-4 p-2">
              مروری بر چشم‌انداز
            </a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card custom-card h-100 text-center">
          
          <img src="{{asset('assets/images/card/digital-marketing.png')}}" 
          class="img-fluid mt-2 mb-3 mx-auto" style="max-height:60px;" alt="Rinotex">

          <div class="card-body d-flex flex-column">
            <i class="bi bi-megaphone-fill"></i>
            <h5 class="card-title">رسانه‌ها درباره رخشای</h5>
            <p class="card-text flex-grow-1">
              نظر رسانه‌ها و کارشناسان در مورد اولین پلتفرم هوش مصنوعی ایرانی.
            </p><p><b>رخشای از دید رسانه با دیدی متفاوت از بیرون</b></p>
            <a href="https://rakhshai.com/news/analysis-of-the-media-and-experts-about-the-first-iranian-artificial-intelligence-platform-rakhshai/" 
               class="btn-gr btn-o-style-4 p-2">
              بیشتر بخوانید
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<style>

.custom-card {
  background: rgba(255, 255, 255, 0.05); 
  border: none;
  border-radius: 1rem;                  
  box-shadow: 0 8px 16px rgba(0,0,0,0.4);
  color: #e1e1e8;                      
  overflow: hidden;                     
}

.custom-card img {
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
}
</style>

<section class="news-section">
  <div class="container py-5">
    <h3 class="text-center mt-4 mb-5 section-title">آخرین مطالب نشریه هوش مصنوعی رخشای</h3>
    <div class="row mt-4 g-4 news-slider owl-carousel owl-theme">
      @foreach ($blogPosts as $post)
          @if($post->link != 'https://rakhshai.com/news/en/unveiling-of-dialogue-tones-in-the-new-version-of-iranian-artificial-intelligence-zal-rakhshai-version-0-2-0/')
      <div class="col news-item">
        <div class="card h-100 news-item-inner">
          <a class="news-link" href="{{$post->link}}">
            <img src="{{$post->medium}}" class="card-img-top" alt="{{$post->title}}">
          </a>
          <div class="card-body">
            <h5 class="card-title mb-4">
              <a class="news-link" href="{{$post->link}}">{!!$post->title!!}</a>
            </h5>
            <p class="card-text">
              <a class="news-link" href="{{$post->link}}">{!!$post->content!!}</a>
            </p>
            <a href="{{$post->link}}" class="btn-gr btn-o-style-4">بیشتر...</a>
          </div>
        </div>
      </div>
            @endif
      @endforeach
    </div>
      <div class="text-center"> <a href="{{url('news')}}" class="btn-gr style-3">مقالات بیشتر</a></div>
  </div>
</section>

<section class="counters-sec" id="counters">
  <div class="container counters-inner">
    <div class="row">
      <div class="col-md-3">
        <div class="counter-box">
          <h2 class="counter">{{$countSection['users']}}</h2>
          <p class="counter-label">تعداد کاربران</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="counter-box">
          <h2 class="counter">{{$countSection['questions']}}</h2>
          <p class="counter-label">تعداد گفتگوها</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="counter-box">
          <h2 class="counter">{{$countSection['images']}}</h2>
          <p class="counter-label">تعداد عکس ها</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="counter-box">
          <h2 class="counter">{{$userAiCounts}}</h2>
          <p class="counter-label">هوش مصنوعی کاربران</p>
          
        </div>
      </div>
    </div>
  </div>
</section>


</main>

<!-- Footer -->
@include('layouts.footer')

<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/lottieplayer.js')}}"></script>
<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/videojs.js')}}"></script>
<script src="{{asset('assets/js/three.js')}}"></script>
<script src="{{asset('assets/js/imagesloaded.js')}}"></script>
<script src="{{asset('assets/js/tweenmax.js')}}"></script>
{{-- <script src="{{asset('assets/js/masonry.js')}}"></script> --}}
<script src="{{asset('assets/js/script.js')}}"></script>

    {{-- <script src="http://code.responsivevoice.org/responsivevoice.js"></script> --}}
<script>
  document.addEventListener("DOMContentLoaded", function(event) {
      var horseAnimation = document.getElementById("horse-animation");

      if(horseAnimation){
        setTimeout(()=>{
        horseAnimation.play();
          setTimeout(function() {
            horseAnimation.pause();
          }, 8000);
        },700)
      }

    });

  $('.news-slider').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
    nav:true,
    items:3,
    responsive:{
        0:{
            items:1,
            margin:0
        },
        600:{
            items:2,
        },
        1000:{
            items:3
        }
    }
})

$('.customers-slider').owlCarousel({
    rtl:true,
    loop:false,
    margin:20,
    nav:false,
    items:3
})

$('.home-usages').owlCarousel({
    rtl:true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    loop:true,
    dots:false,
    nav:false,
     autoWidth:true,
    items:10,
    responsive:{
        0:{
            items:1,
            margin:0
        },
        600:{
            items:2,
        },
        1000:{
            items:10
        }
    }
})

const displacementSlider = function (opts) {
    let vertex = `
        varying vec2 vUv;
        void main() {
            vUv = uv;
            gl_Position = projectionMatrix * modelViewMatrix * vec4( position, 1.0 );
        }
    `;
    
    let fragment = `
        varying vec2 vUv;

        uniform sampler2D currentImage;
        uniform sampler2D nextImage;
        uniform float dispFactor;

        void main() {
            vec2 uv = vUv;
            vec4 _currentImage;
            vec4 _nextImage;
            float intensity = 0.3;

            vec4 orig1 = texture2D(currentImage, uv);
            vec4 orig2 = texture2D(nextImage, uv);
            
            _currentImage = texture2D(currentImage, vec2(uv.x, uv.y + dispFactor * (orig2 * intensity)));
            _nextImage = texture2D(nextImage, vec2(uv.x, uv.y + (1.0 - dispFactor) * (orig1 * intensity)));

            vec4 finalTexture = mix(_currentImage, _nextImage, dispFactor);
            gl_FragColor = finalTexture;
        }
    `;
    
    let images = opts.images,
        sliderImages = [];
    
    let canvasWidth = images[0].clientWidth;
    let canvasHeight = images[0].clientHeight;
    let parent = opts.parent;
    let renderWidth = parent.offsetWidth;
    let renderHeight = parent.offsetHeight;

    // Calculate aspect ratio
    let aspect = canvasWidth / canvasHeight;
    let imageAspect = renderWidth / renderHeight;
    let a1, a2;

    if (imageAspect > aspect) {
        a1 = 1;
        a2 = imageAspect / aspect;
    } else {
        a1 = (aspect / imageAspect);
        a2 = 1;
    }

    let renderer = new THREE.WebGLRenderer({ antialias: false , alpha: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setClearColor(0x1a1c1e, 1.0);
    renderer.setSize(renderWidth, renderHeight);
    parent.appendChild(renderer.domElement);
    
    let loader = new THREE.TextureLoader();
    loader.crossOrigin = "anonymous";
    images.forEach(img => {
        let image = loader.load(img.getAttribute("src") + "?v=" + Date.now());
        image.magFilter = image.minFilter = THREE.LinearFilter;
        image.anisotropy = renderer.capabilities.getMaxAnisotropy();
        sliderImages.push(image);
    });

    let scene = new THREE.Scene();
    scene.background = new THREE.Color(0x1a1c1e);
    
    let camera = new THREE.OrthographicCamera(renderWidth / -2, renderWidth / 2, renderHeight / 2, renderHeight / -2, 1, 1000);
    camera.position.z = 1;

    let mat = new THREE.ShaderMaterial({
        uniforms: {
            dispFactor: { type: "f", value: 0.0 },
            currentImage: { type: "t", value: sliderImages[0] },
            nextImage: { type: "t", value: sliderImages[1] }
        },
        vertexShader: vertex,
        fragmentShader: fragment,
        transparent: true,
        opacity: 1.0
    });

    // Adjust Plane Geometry based on aspect ratios
    let geometry = new THREE.PlaneBufferGeometry(parent.offsetWidth * a1, parent.offsetHeight * a2, 1);
    let object = new THREE.Mesh(geometry, mat);
    object.position.set(0, 0, 0);
    scene.add(object);

    let currentSlide = 0;
    let isAnimating = false;
    const slideDuration = 6000; // Time in milliseconds for each slide
    let autoSlideInterval; // Declare the interval variable

    const updateNavigationAndContent = function(slideId) {
        // Update pagination buttons
        document.querySelector("#pagination .active").classList.remove("active");
        document.querySelector(`#pagination button[data-slide="${slideId}"]`).classList.add("active");

        // Update slide title and status
        let slideTitleEl = document.getElementById("slide-title");
        let slideStatusEl = document.getElementById("slide-status");
        let nextSlideTitle = document.querySelector(`[data-slide-title="${slideId}"]`).innerHTML;
        let nextSlideStatus = document.querySelector(`[data-slide-status="${slideId}"]`)?.innerHTML || "";

        // Animate title and status change
        TweenLite.fromTo(slideTitleEl, 0.5, { autoAlpha: 1, y: 0 }, {
            autoAlpha: 0,
            y: 20,
            ease: "Expo.easeIn",
            onComplete: function () {
                slideTitleEl.innerHTML = nextSlideTitle;
                TweenLite.to(slideTitleEl, 0.5, { autoAlpha: 1, y: 0 });
            }
        });

        TweenLite.fromTo(slideStatusEl, 0.5, { autoAlpha: 1, y: 0 }, {
            autoAlpha: 0,
            y: 20,
            ease: "Expo.easeIn",
            onComplete: function () {
                slideStatusEl.innerHTML = nextSlideStatus;
                TweenLite.to(slideStatusEl, 0.5, { autoAlpha: 1, y: 0, delay: 0.1 });
            }
        });

        // Update slide buttons
        let slideButtonsEl = document.querySelector(`span[data-slide-buttons="${slideId}"]`);
        let buttonsContainer = document.getElementById("btn-box-slider");

        TweenLite.to(buttonsContainer, 0.5, {
        autoAlpha: 0,
        y: 20,
        ease: "Expo.easeIn",
        onComplete: function () {
            // Remove current buttons
            buttonsContainer.innerHTML = '';

            // Append new buttons for the current slide
            let newButtons = slideButtonsEl.querySelector("ul").cloneNode(true);
            buttonsContainer.appendChild(newButtons);

            // Animate new buttons in
            TweenLite.fromTo(buttonsContainer, 0.5, { autoAlpha: 0, y: 20 }, {
                autoAlpha: 1,
                y: 0,
                ease: "Expo.easeOut"
            });
        }
    });
    };

    const goToSlide = function(slideId) {
        if (!isAnimating) {
            isAnimating = true;
            mat.uniforms.nextImage.value = sliderImages[slideId];
            mat.uniforms.nextImage.needsUpdate = true;

            TweenLite.to(mat.uniforms.dispFactor, 1, {
                value: 1,
                ease: "Expo.easeInOut",
                onComplete: function () {
                    mat.uniforms.currentImage.value = sliderImages[slideId];
                    mat.uniforms.currentImage.needsUpdate = true;
                    mat.uniforms.dispFactor.value = 0.0;
                    isAnimating = false;
                }
            });

            // Update navigation and content
            updateNavigationAndContent(slideId);
        }
    };

    const goToNextSlide = function() {
        if (!isAnimating) {
            currentSlide = (currentSlide + 1) % sliderImages.length;
            goToSlide(currentSlide);
        }
    };

    const addEvents = function () {
    let pagButtons = Array.from(document.getElementById("pagination").querySelectorAll("button"));
    let btnBoxes = Array.from(document.querySelectorAll(".btn-box-slider")); // Target all button containers

        // Function to pause slider on hover
        const pauseSlider = () => clearInterval(autoSlideInterval);

        // Function to resume slider on hover out
        const resumeSlider = () => autoSlideInterval = setInterval(goToNextSlide, slideDuration);

        // Add hover events for pagination buttons
        pagButtons.forEach((el) => {
            el.addEventListener("click", function () {
                if (!isAnimating) {
                    let slideId = parseInt(this.dataset.slide, 10);
                    currentSlide = slideId;
                    goToSlide(slideId);
                }
            });

            el.addEventListener("mouseenter", pauseSlider);
            el.addEventListener("mouseleave", resumeSlider);
        });

        // Add hover events for buttons inside each slide
        btnBoxes.forEach((btnBox) => {
            btnBox.addEventListener("mouseenter", pauseSlider);
            btnBox.addEventListener("mouseleave", resumeSlider);
        });
    };

    // Call addEvents to add hover events for both pagination and buttons
    addEvents();

    // Auto-slide interval
    autoSlideInterval = setInterval(goToNextSlide, slideDuration);

    window.addEventListener("resize", function () {
        renderWidth = parent.offsetWidth;
        renderHeight = parent.offsetHeight;
        renderer.setSize(renderWidth, renderHeight);
        camera.left = renderWidth / -2;
        camera.right = renderWidth / 2;
        camera.top = renderHeight / 2;
        camera.bottom = renderHeight / -2;
        camera.updateProjectionMatrix();
    });

    let animate = function () {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    };
    
    animate();
};

imagesLoaded(document.querySelectorAll("img"), () => {
    document.body.classList.remove("loading");
    const el = document.getElementById("slider");
    const imgs = Array.from(el.querySelectorAll(".slider-img-item"));
    new displacementSlider({
        parent: el,
        images: imgs
    });
});


// images grid
const gridType1 = [
  {
    src: 'https://rakhshai.com/images/2024-08-18/c26ff750-5f17-4821-ae6d-d07b9504168f11354-1724009450-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/35047ffa-1616-4a16-84c2-109c01473813'
  },
  {
    src: 'https://rakhshai.com/images/2024-08-16/db6e8c9c-9d28-4923-a8f4-7a88c70c739911274-1723763401-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/8c39d83e-3343-4ed6-8a1b-eddd25e8f2ed'
  },
  {
    src: 'https://rakhshai.com/images/2024-08-28/584b2bed-7139-4dbc-9e83-2bd0cf9754119707-1724873804-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/aace591c-1902-476c-b74b-c2b4c1a9ee18'
  },
  {
    src: 'https://rakhshai.com/images/2024-06-17/8d4c485f-c897-4c66-a9e6-f113b63aad4f9707-1718654463-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/97491f47-11a9-4709-b2f1-71046987e5f0'
  },
  {
    src: 'https://rakhshai.com/images/2024-06-24/55c17425-3851-43e8-9afb-71c026b012761797-1719211856-thumbnail.jpg' , 
    link : 'http://rakhshai.com/explore/image/0a266d0a-8e56-4856-9cf2-4f1e4b41b31e'
  },
  {
    src: 'https://rakhshai.com/images/2024-05-28/fdc33331-b8ba-482d-b223-594f9969bceb9740-1716882456-thumbnail.jpg' , 
    link : 'http://rakhshai.com/explore/image/98ac4642-abc0-4ffd-aa6b-bae60def480f'
  }
]
const gridType2 = [
  {
    src: 'https://rakhshai.com/images/2024-01-29/0873dc22-b077-45b4-b7b7-50674d35215d6464-1706556087-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/4ef157ed-bc7a-4873-9d29-a7760ba1e162'
  },
  {
    src: 'https://rakhshai.com/images/2024-07-19/7fe344ee-70df-4919-848b-dda226dbca309707-1721417258-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/96d8e25c-f845-4753-8581-968fcbc620f1'
  },
  {
    src: 'https://rakhshai.com/images/2024-05-31/5029bf3f-aeeb-49fd-bb91-a83b6213c0899707-1717151791-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/3e8a1c42-5fc7-4cfa-b748-777b2f06bef1'
  },
  {
    src: 'https://rakhshai.com/images/2024-07-19/8edf3e7b-b29c-47f5-be25-e4d8957831d49707-1721417217-thumbnail.jpg' , 
    link : 'http://rakhshai.com/explore/image/96d8e25c-f845-4753-8581-968fcbc620f1'
  }
]
const gridType3 = [
  {
    src: 'https://rakhshai.com/images/2024-05-28/2f6421b2-5a5b-4ac0-bbcd-1c2e351d83019707-1716891892-thumbnail.jpg' ,
    link : 'https://rakhshai.com/explore/image/78bbdfcb-697f-47c2-8a51-861f3a742d66'
  },
  {
    src: 'https://rakhshai.com/images/2024-05-16/025b992b-f3c7-4b93-bc06-5a329cdfad8b9536-1715868675-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/536e0ed7-3a95-467b-b3d2-784db1657d89'
  },
  {
    src: 'https://rakhshai.com/images/2024-05-16/1d2b247e-db01-42bb-a128-81c4875038b49536-1715843689-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/af760895-ca14-4222-9a3a-5e090d1f8803'
  },
  {
    src: 'https://rakhshai.com/images/2024-05-16/6a4b2d80-8cce-4630-b079-ec17e1fe7c3c9536-1715876830-thumbnail.jpg' , 
    link : 'https://rakhshai.com/explore/image/cac19fa8-87fb-4e50-9a71-cda023125b69'
  }
]

let availableItems1 = [...gridType1];
let availableItems2 = [...gridType2];
let availableItems3 = [...gridType3];

const imageBoxes = [$('#image-box-1'), $('#image-box-2'), $('#image-box-3'), $('#image-box-4'), $('#image-box-5')];

function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
    }

function selectRandomBox() {
  imageBoxes.forEach(box => box.removeClass('selected blink-1'));

  const randomIndex = Math.floor(Math.random() * imageBoxes.length);

  let randomImg = {};
  
  imageBoxes[randomIndex].addClass('selected blink-1');
  if(imageBoxes[randomIndex].hasClass('grid-item-1')){
    if (availableItems1.length === 0) {
            availableItems1 = [...gridType1];
            shuffle(availableItems1);
    }
    randomImg = availableItems1.shift();
  }

  if(imageBoxes[randomIndex].hasClass('grid-item-2')){
    if (availableItems1.length === 0) {
            availableItems2 = [...gridType2];
            shuffle(availableItems2);
    }
    randomImg = availableItems2.shift();
  }

  if(imageBoxes[randomIndex].hasClass('grid-item-3')){
    if (availableItems1.length === 0) {
            availableItems3 = [...gridType3];
            shuffle(availableItems3);
    }
    randomImg = availableItems3.shift();
  }

  imageBoxes[randomIndex].attr('href', randomImg.link);
  imageBoxes[randomIndex].find('img').attr('src', randomImg.src);

}

setInterval(selectRandomBox, 6000);


</script>
@endsection
