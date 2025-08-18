{{-- <div class="offer-box">
    <div class="right-side">
        <lottie-player autoplay loop src="{{asset('assets/images/animations/discount.json')}}" background="transparent"
    speed="1" style="width: 60px; height: 60px;"></lottie-player>
        <span class="txt1">30% تخفیف روی تمامی پکیج های رخشای</span></div>
        <div class="left-side">
            <div id="timer"></div>
            <lottie-player autoplay src="{{asset('assets/images/animations/gift.json')}}" background="transparent"
            speed="1" style="width: 120px; height: 80px;position:relative;bottom:8px"></lottie-player>
        </div>
</div> --}}
<header class="navbar navbar-expand-md d-flex flex-column pb-0" {{-- style="margin-top: 65px" --}}>
    <div class="container-lg header-container">
        <div class="header-top-right">
            <a class="navbar-brand" href="{{url('/')}}">
                <img class="logo" width="92" height="60" src="{{asset('assets/images/main/logo-v2.webp')}}" alt="Logo">
            </a>
            {{-- <a class="header-link" href="#">درباره رخشای</a>
            <a class="header-link" href="#">چرا رخشای؟</a> --}}

            <div class="nav-inner">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav main-navbar mobile-navbar">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('chat')}}">چت با زال</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('image')}}">ساخت عکس با شهرزاد</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('plans')}}">خرید پکیج</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{url('about-us')}}">درباره ما</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('news')}}">بلاگ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('explore')}}">تصاویر عمومی</a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('auth/logout')}}">خروج</a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-top-left">
            {{-- <a href="{{url('about-us')}}" class="btn-1">درباره رخشای</a> --}}

            @guest
            <ul class="btn-box">
                <li class="nav-item">
                    <a class="nav-link btn-2" href="{{url('auth/register')}}">ثبت نام</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-btn" href="{{url('auth/login')}}">ورود</a>
                </li>
            </ul>
            @endguest
        </div>
    </div>
    {{-- <div class="container-fluid header-bottom">
        <div class="container">
            
        </div>
    </div> --}}
</header>
