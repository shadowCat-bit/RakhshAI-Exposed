@extends('admin.layouts.public', ['title' => 'چت های عمومی'])
@section('content')

<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-lg-flex">
                <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-3">
                    <div class="card">
                        <div class="p-3 px-lg-4 border-bottom">
                            <div class="row">
                                <div class="col-xl-4 col-7">
                                    <div class="d-flex align-items-center">
                                        {{-- <div class="flex-shrink-0 avatar-sm me-3 d-sm-block d-none">
                                            <img src={{asset("admin-assets/images/users/avatar-2.jpg")}} alt=""
                                                class="img-fluid d-block rounded-circle">
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-xl-8 col-5">
                                    <ul class="list-inline user-chat-nav text-end mb-0">
                                        <li class="list-inline-item">
                                            <div class="dropdown">
                                                <button class="btn nav-btn dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="bx bx-search"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                                                    <form class="px-2">
                                                        <div>
                                                            <input type="text" class="form-control border bg-soft-light"
                                                                placeholder="جستجو کردن...">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="list-inline-item">
                                            <div class="dropdown">
                                                <button class="btn nav-btn dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">پروفایل</a>
                                                    <a class="dropdown-item" href="#">بایگانی </a>
                                                    <a class="dropdown-item" href="#">بی صدا </a>
                                                    <a class="dropdown-item" href="#">حذف</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="chat-conversation p-3" data-simplebar="">
                            <ul class="list-unstyled mb-0">
                                {{-- <li class="chat-day-title">
                                    <span class="title">امروز</span>
                                </li> --}}
                                @php ($preChannel = '')
                                @foreach ($messages as $msg)
                                    @if ($preChannel != $msg->channel)
                                        @php ($preChannel = $msg->channel)
                                        <hr>
                                    @endif
                                @if ($msg->role == 'user')
                                <li>
                                    <div class="conversation-list">
                                        <div class="d-flex">
                                            <img src={{asset("admin-assets/images/users/avatar-3.jpg")}}
                                                class="rounded-circle avatar-sm" alt="">
                                            <div class="flex-1">
                                                <div class="ctext-wrap">
                                                    <div class="ctext-wrap-content">
                                                        <div class="conversation-name"><span
                                                                class="time">{{$msg->created_at->format('H:i:s')}}</span>
                                                        </div>
                                                        <p class="mb-0">{{$msg->content}}</p>
                                                    </div>
                                                    <div class="dropdown align-self-start">
                                                        <a class="dropdown-toggle" href="#" role="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">کپی </a>
                                                            <a class="dropdown-item" href="#">ذخیره </a>
                                                            <a class="dropdown-item" href="#">فوروارد </a>
                                                            <a class="dropdown-item" href="#">حذف</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li class="right">
                                    <div class="conversation-list">
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <div class="ctext-wrap">
                                                    <div class="ctext-wrap-content">
                                                        <div class="conversation-name"><span
                                                                class="time">{{$msg->created_at->format('H:i:s')}}</span>
                                                        </div>
                                                        <p class="mb-0">{{$msg->content}}</p>
                                                    </div>
                                                    <div class="dropdown align-self-start">
                                                        <a class="dropdown-toggle" href="#" role="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">کپی </a>
                                                            <a class="dropdown-item" href="#">ذخیره </a>
                                                            <a class="dropdown-item" href="#">فوروارد </a>
                                                            <a class="dropdown-item" href="#">حذف</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src={{asset("admin-assets/images/users/avatar-6.jpg")}}
                                                class="rounded-circle avatar-sm" alt="">
                                        </div>

                                    </div>

                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>

                        <div class="p-3 border-top">
                            <div class="row">
                                <div class="col">

                                </div>
                                <div class="col-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end user chat -->
            </div>
            <!-- End d-lg-flex  -->
            {{$messages->links('admin.layouts.custom-pagination')}}
        </div> <!-- container-fluid -->

    </div>
    <!-- End Page-content -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <script>
                        document.write(new Date().getFullYear())
                    </script>2022 © Borex. طراحی و توسعه توسط Themesbrand
                </div>
            </div>
        </div>
    </footer>

</div>
<!-- end main content-->

@endsection