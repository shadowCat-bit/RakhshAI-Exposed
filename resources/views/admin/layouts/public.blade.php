<!doctype html>
<html lang="fa" dir="rtl">

<!--/dashboard-saas.html 13:47:06 GMT -->
<head>
    <meta charset="utf-8" />
    <title>رخشای | ادمین</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href={{asset("admin-assets/images/fav.ico")}}>

    <!-- plugin css -->
    <link href={{asset("admin-assets/libs/jsvectormap/css/jsvectormap.min.css")}} rel="stylesheet" type="text/css" />

    <!-- swiper Css -->
    <link href={{asset("admin-assets/libs/swiper/swiper-bundle.min.css")}} rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href={{asset("admin-assets/css/bootstrap-rtl.min.css")}} id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href={{asset("admin-assets/css/icons.min.css")}} rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href={{asset("admin-assets/css/app-rtl.min.css")}} id="app-style" rel="stylesheet" type="text/css" />
    <link href={{asset("admin-assets/css/rtl.css")}} rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar" class="isvertical-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src={{asset("admin-assets/images/logo-dark-sm.png")}} alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src={{asset("admin-assets/images/logo-dark-sm.png")}} alt="" height="22">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-lg">
                                <img src={{asset("admin-assets/images/logo-light.png")}} alt="" height="22">
                            </span>
                            <span class="logo-sm">
                                <img src={{asset("admin-assets/images/logo-light-sm.png")}} alt="" height="22">
                            </span>
                        </a>
                    </div>

                    <button type="button"
                        class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn topnav-hamburger">
                        <div class="hamburger-icon open">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <div class="d-none d-sm-block ms-3 align-self-center">
                        <h4 class="page-title">{{$title}}</h4>
                    </div>

                </div>

            </div>
        </header>

        <!-- ========== Right Sidebar Start ========== -->
        <div class="vertical-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{route('admin.index')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src={{asset("admin-assets/images/logo-dark-sm.png")}} alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src={{asset("admin-assets/images/logo-dark.png")}} alt="" height="22">
                    </span>
                </a>

                <a href="{{route('admin.index')}}" class="logo logo-light">
                    <span class="logo-lg">
                        <img src={{asset("admin-assets/images/logo-light.png")}} alt="" width="60">
                    </span>
                    <span class="logo-sm">
                        <img src={{asset("admin-assets/images/logo-light-sm.png")}} alt="" height="22">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 header-item vertical-menu-btn topnav-hamburger">
                <div class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <div data-simplebar="" class="sidebar-menu-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" data-key="t-menu">منو</li>

                        <li>
                            <a href="{{route('admin.index')}}">
                                <i class="icon nav-icon" data-eva="grid-outline"></i>
                                <span class="menu-item" data-key="t-calendar">داشبورد</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('admin.users.list')}}">
                                <i class="icon nav-icon" data-eva="person-done-outline"></i>
                                <span class="menu-item" data-key="t-calendar">کاربران</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('admin.chats.public')}}">
                                <i class="icon nav-icon" data-eva="message-circle-outline"></i>
                                <span class="menu-item" data-key="t-calendar">چت های عمومی</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('admin.users-ai.list')}}">
                                <i class="icon nav-icon" data-eva="message-circle-outline"></i>
                                <span class="menu-item" data-key="t-calendar">هوش مصنوعی کاربران</span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="icon nav-icon" data-eva="grid-outline"></i>
                                <span class="menu-item" data-key="t-calendar">مالی</span>
                                <span class="menu-arrow"></span> 
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="{{route('admin.finance.purchased')}}">
                                        <span class="menu-item" data-key="t-calendar">لیست فروش</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.finance.purchased.period')}}">
                                        <span class="menu-item" data-key="t-calendar">فروش بازه ای</span>
                                    </a>
                                </li>
                                <!-- Add more submenu items as needed -->
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>

        @yield('content')

    </div>

    <!-- JAVASCRIPT -->
    <script src={{asset("admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js")}}></script>
    <script src={{asset("admin-assets/libs/metismenujs/metismenujs.min.js")}}></script>
    <script src={{asset("admin-assets/libs/simplebar/simplebar.min.js")}}></script>
    <script src={{asset("admin-assets/libs/eva-icons/eva.min.js")}}></script>

    <!-- apexcharts -->
    <script src={{asset("admin-assets/libs/apexcharts/apexcharts.min.js")}}></script>

    <!-- Vector map-->
    <script src={{asset("admin-assets/libs/jsvectormap/js/jsvectormap.min.js")}}></script>
    <script src={{asset("admin-assets/libs/jsvectormap/maps/world-merc.js")}}></script>

    <!-- swiper js -->
    <script src={{asset("admin-assets/libs/swiper/swiper-bundle.min.js")}}></script>

    <!-- dashboard init -->
    <script src={{asset("admin-assets/js/pages/dashboard-saas.init.js")}}></script>

    <script src={{asset("admin-assets/js/app.js")}}></script>

</body>

<!--/dashboard-saas.html 13:47:10 GMT -->

</html>