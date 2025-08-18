
@extends('admin.layouts.public', ['title' => 'کاربران'])
@section('content')

<div class="main-content">
    
    <div class="page-content">
        <div class="container-fluid">

            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="mb-3">
                        <h5 class="card-title">تعداد کاربران <span class="text-muted fw-normal ms-2">({{$userCount}})</span></h5>
                    </div>
                </div>

                <div class="col-md-3">
                    <form method="get" action="">
                        <div class="form-floating mb-3">
                            <input class="form-input" name="search" value="{{request('search')}}">
                            <label for="floatingSelectGrid">جستجو</label>
                        </div>
                    </form>
                </div>

                <div class="col-md-3">
                    <form method="get" action="" id="form_sort">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectGrid" onchange="submitForm()" name="sortby">
                                <option selected="">انتخاب کنید</option>
                                <option value="max_chats" @selected(request('sortby') == 'max_chats')>بیشترین پیام ها</option>
                                <option value="max_tokens" @selected(request('sortby') == 'max_tokens')>بیشترین سکه ها</option>
                                <option value="max_payment" @selected(request('sortby') == 'max_payment')>بیشترین خرید</option>
                            </select>
                            <label for="floatingSelectGrid">مرتب سازی بر اساس</label>
                        </div>
                    </form>
                </div>
                
            </div>
            <!-- end row -->

            <div class="row">

                @foreach ($users as $user)
                    <div class="col-xl-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">ویرایش </a>
                                        <a class="dropdown-item" href="#">اقدام </a>
                                        <a class="dropdown-item" href="#">حذف</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md">
                                        <div class="avatar-title bg-soft-primary text-primary display-6 m-0 rounded-circle">
                                            <i class="bx bxs-user-circle"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 ms-3">
                                        <h5 class="font-size-16 mb-1"><a href="#" class="text-dark">{{$user->name}}</a></h5>
                                        {{-- <span class="badge badge-soft-warning mb-0">توسعه دهنده Backend</span> --}}
                                    </div>
                                </div>
                                <div class="mt-3 pt-1">
                                    <p class="text-muted mb-0"><i class="mdi mdi-phone font-size-15 align-middle pe-2 text-succes"></i>
                                        {{$user->mobile}}</p>
                                    <p class="text-muted mb-0 mt-2"><i
                                            class="fas fa-user font-size-15 align-middle pe-2 text-dark"></i>
                                        {{$user->name . ' ' . $user->email}}</p>
                                    <p class="text-muted mb-0 mt-2"><i
                                        class="fas fa-coins font-size-15 align-middle pe-2 text-warning"></i>
                                    {{$user->userToken->remaining_tokens}}</p>                                    
                                    <p class="text-muted mb-0 mt-2">
                                        <i class="fas fa-money-bill-wave font-size-15 align-middle pe-2 text-danger"></i>
                                        <a href="{{route('admin.finance.purchased', ['search' => $user->mobile])}}">{{($user->sum_tr ?? 0) . ' تومان' . ' (' . ($user->total_tr ?? 0) . ' پکیج)'}}</a>
                                    </p>
                                    <p class="text-muted mb-0 mt-2">
                                        <i class="mdi mdi-clock font-size-15 align-middle pe-2 text-info"></i>
                                        <span dir="ltr">
                                        {{$user->created_at->diffForHumans()}}
                                        </span>
                                    </p>
                                </div>
                    
                                <div class="d-flex gap-2 pt-4">
                                    <a href="{{route('admin.chats.list', ['user_id' => $user->id])}}" class="btn btn-soft-primary btn-sm w-50">
                                        <i class="bx bx-user me-1"></i>گفتگوها ({{$user->total_conv ?? 0}})
                                    </a>
                                    <a href="{{route('admin.chats.list', ['user_id' => $user->id])}}" class="btn btn-primary btn-sm w-50">
                                        <i class="bx bx-message-square-dots me-1"></i>پیام ها ({{$user->total_msg ?? 0}})
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                @endforeach
                
            </div>
            <!-- end row -->

            
            {{ $users->links('admin.layouts.custom-pagination') }}
            
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

<script>
    function submitForm() {
        document.getElementById("form_sort").submit();
    }
</script>

@endsection