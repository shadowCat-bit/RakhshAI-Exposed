@extends('admin.layouts.public', ['title' => 'چت ها'])
@section('content')

                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-content">
    
                    <div class="page-content">
                        <div class="container-fluid">
    
                            <div class="d-lg-flex">
                                <div class="chat-leftsidebar card">
                                    <div class="card-body">
                                        
                                       <div class="text-center bg-light rounded px-4 py-3">
                                                <div class="text-end">
                                                    <div class="dropdown chat-noti-dropdown">
                                                        <button class="btn dropdown-toggle p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bx bx-cog"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#"></a>
                                                            <a class="dropdown-item" href="#">ویرایش </a>
                                                            <a class="dropdown-item" href="#">نمایه </a><a class="dropdown-item" href="#">افزودن </a>
                                                            <a class="dropdown-item" href="#">تنظیمات تماس</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="chat-user-status">
                                                    <img src={{asset("admin-assets/images/users/avatar-1.jpg")}} class="avatar-md rounded-circle" alt="">
                                                    <div class="">
                                                        <div class="status"></div>
                                                    </div>
                                                </div>
                                                <h5 class="font-size-16 mb-1 mt-3"><a href="#" class="text-dark">{{$user->name}}</a></h5>
                                                <p class="text-muted mb-0">{{$user->mobile}}</p>
                                       </div>
                                    </div>
    
                                    <div class="p-3">
                                        <div class="search-box position-relative">
                                            <input type="text" class="form-control rounded border" placeholder="جستجو کردن...">
                                            <i class="search-icon" data-eva="search-outline" data-eva-height="26" data-eva-width="26"></i>
                                        </div>
                                    </div>
    
                                    <div class="chat-leftsidebar-nav">
                                        <ul class="nav nav-pills nav-justified bg-light p-1">
                                            <li class="nav-item">
                                                <a href="#chat" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                                    <i class="bx bx-chat font-size-20 d-sm-none"></i>
                                                    <span class="d-none d-sm-block">گفتگوها</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="chat">
                                                <div class="chat-message-list" data-simplebar="">
                                                    <div class="pt-3">
                                                        {{-- <div class="px-3">
                                                            <h5 class="font-size-14 mb-3">اخیر</h5>
                                                        </div> --}}
                                                        <ul class="list-unstyled chat-list">
                                                            @foreach ($convs as $conv)
                                                                <li>
                                                                    <a href="{{route('admin.chats.list', ['conv_id' => $conv->id, 'user_id' => $user->id])}}">
                                                                        <div class="d-flex align-items-start">
                                                                            <div class="flex-grow-1 overflow-hidden">
                                                                                <h5 class="text-truncate font-size-13 mb-1 {{request()->conv_id == $conv->id ? 'text-primary' : ''}}">{{$conv->title}}</h5>
                                                                            </div>
                                                                            <div class="flex-shrink-0">
                                                                                <div class="font-size-11" dir="ltr">{{$conv->created_at->diffForHumans()}}</div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="tab-pane" id="groups">
                                                <div class="chat-message-list" data-simplebar="">
                                                    <div class="pt-3">
                                                        <div class="px-3">
                                                            <h5 class="font-size-14 mb-3">گروه ها</h5>
                                                        </div>
                                                        <ul class="list-unstyled chat-list">
                                                            <li>
                                                                <a href="#">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 avatar-sm me-3">
                                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                                جی
                                                                            </span>
                                                                        </div>
                                                                        
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="font-size-13 mb-0">عمومی</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
    
                                                            <li>
                                                                <a href="#">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 avatar-sm me-3">
                                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                                آر
                                                                            </span>
                                                                        </div>
                                                                        
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="font-size-13 mb-0">گزارش نویسی</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
    
                                                            <li>
                                                                <a href="#">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 avatar-sm me-3">
                                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                                م
                                                                            </span>
                                                                        </div>
                                                                        
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="font-size-13 mb-0">ملاقات</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
    
                                                            <li>
                                                                <a href="#">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 avatar-sm me-3">
                                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                                آ
                                                                            </span>
                                                                        </div>
                                                                        
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="font-size-13 mb-0">پروژه A</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
    
                                                            <li>
                                                                <a href="#">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 avatar-sm me-3">
                                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                                ب
                                                                            </span>
                                                                        </div>
                                                                        
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="font-size-13 mb-0">پروژه B</h5>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="tab-pane" id="contacts">
                                                <div class="chat-message-list" data-simplebar="">
                                                    <div class="pt-3">
                                                        <div class="px-3">
                                                            <h5 class="font-size-14 mb-3">مخاطب</h5>
                                                        </div>
    
                                                        <div>
                                                            <div>
                                                                <div class="px-3 contact-list">آ</div>
    
                                                                <ul class="list-unstyled chat-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <h5 class="font-size-13 mb-0">آدام میلر</h5>
                                                                        </a>
                                                                    </li>
                
                                                                    <li>
                                                                        <a href="#">
                                                                            <h5 class="font-size-13 mb-0">آلفونسو فیشر</h5>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
    
                                                            <div class="mt-4">
                                                                <div class="px-3 contact-list">ب</div>
    
                                                                <ul class="list-unstyled chat-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <h5 class="font-size-13 mb-0">بانی هارنی</h5>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
    
                                                            <div class="mt-4">
                                                                <div class="px-3 contact-list">سی</div>
    
                                                                <ul class="list-unstyled chat-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <h5 class="font-size-13 mb-0">چارلز براون</h5>
                                                                        </a>
                                                                        <a href="#">
                                                                            <h5 class="font-size-13 mb-0">کارملا جونز</h5>
                                                                        </a>
                                                                        <a href="#">
                                                                            <h5 class="font-size-13 mb-0">کری ویلیامز</h5>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
    
                                                            <div class="mt-4">
                                                                <div class="px-3 contact-list">دی</div>
    
                                                                <ul class="list-unstyled chat-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <h5 class="font-size-13 mb-0">دولورس مینتر</h5>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                                <!-- end chat-leftsidebar -->
    
                                <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-3">
                                    <div class="card">
                                        <div class="p-3 px-lg-4 border-bottom">
                                            <div class="row">
                                                <div class="col-xl-4 col-7">
                                                    <div class="d-flex align-items-center">
                                                        {{-- <div class="flex-shrink-0 avatar-sm me-3 d-sm-block d-none">
                                                            <img src={{asset("admin-assets/images/users/avatar-2.jpg")}} alt="" class="img-fluid d-block rounded-circle">
                                                        </div> --}}
                                                    </div>
                                                </div>
                                                <div class="col-xl-8 col-5">
                                                    <ul class="list-inline user-chat-nav text-end mb-0">
                                                        <li class="list-inline-item">
                                                            <div class="dropdown">
                                                                <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="bx bx-search"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                                                                    <form class="px-2">
                                                                        <div>
                                                                            <input type="text" class="form-control border bg-soft-light" placeholder="جستجو کردن...">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
        
                                                        <li class="list-inline-item">
                                                            <div class="dropdown">
                                                                <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                @foreach ($convMessages as $msg)
                                                    @if ($msg->role == 'user')
                                                        <li>
                                                            <div class="conversation-list">
                                                                <div class="d-flex">
                                                                    <img src={{asset("admin-assets/images/users/avatar-3.jpg")}} class="rounded-circle avatar-sm" alt="">
                                                                    <div class="flex-1">
                                                                        <div class="ctext-wrap">
                                                                            <div class="ctext-wrap-content">
                                                                                <div class="conversation-name"><span class="time">{{$msg->created_at->format('H:i:s')}}</span></div>
                                                                                <p class="mb-0">{{$msg->content}}</p>
                                                                            </div>
                                                                            <div class="dropdown align-self-start">
                                                                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                                                                <div class="conversation-name"><span class="time">{{$msg->created_at->format('H:i:s')}}</span></div>
                                                                                <p class="mb-0">{{$msg->content}}</p>
                                                                            </div>
                                                                            <div class="dropdown align-self-start">
                                                                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
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
                                                                    <img src={{asset("admin-assets/images/users/avatar-6.jpg")}} class="rounded-circle avatar-sm" alt="">
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
                            
                        </div> <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->
                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <script>document.write(new Date().getFullYear())</script>2022 © Borex. طراحی و توسعه توسط Themesbrand
                                </div>
                            </div>
                        </div>
                    </footer>
                
                </div>
                <!-- end main content-->

@endsection