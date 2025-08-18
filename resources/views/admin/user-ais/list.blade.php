
@extends('admin.layouts.public', ['title' => 'کاربران'])
@section('content')

<div class="main-content">
    
    <div class="page-content">
        <div class="container-fluid">

            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="mb-3">
                        <h5 class="card-title">تعداد هوش مصنوعی <span class="text-muted fw-normal ms-2">({{$aiCounts}})</span></h5>
                    </div>
                </div>

                {{-- <div class="col-md-3">
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
                </div> --}}
                
            </div>
            <!-- end row -->

            <div class="row">

                @foreach ($userAis as $ai)
                    <div class="col-xl-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md">
                                        <div class="text-primary display-6 m-0 rounded-circle">
                                            <img width="60" src="{{$ai->ai_avatar}}" class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-1 ms-3">
                                        <h5 class="font-size-16 mb-1 mx-2"><a href="#" class="text-dark">{{$ai->ai_title}}</a></h5>
                                        {{-- <span class="badge badge-soft-warning mb-0">توسعه دهنده Backend</span> --}}
                                    </div>
                                </div>
                                <div class="mt-3 pt-1">
                                    <p class="text-muted mb-0"><i class="mdi mdi-phone font-size-15 align-middle pe-2 text-succes"></i>
                                        {{$ai->ai_content}}
                                    </p>
                                </div>
                    
                                <div class="d-flex gap-2 pt-4">
                                    <a href="{{route('admin.users-ai.show', ['ai_id' => $ai->id, 'user_id' => $ai->user_id])}}" class="btn btn-soft-primary btn-sm w-50">
                                        <i class="bx bx-user me-1"></i>مشاهده
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                @endforeach
                
            </div>
            <!-- end row -->

            
            {{ $userAis->links('admin.layouts.custom-pagination') }}
            
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