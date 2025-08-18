
@extends('admin.layouts.public', ['title' => 'لیست فروش'])
@section('content')

<div class="main-content">
    
    <div class="page-content">
        <div class="container-fluid">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h5 class="card-title">تعداد سفارشات موفق <span class="text-muted fw-normal ms-2">({{$count}})</span></h5>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">

                @foreach ($items as $item)
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
                                        <h5 class="font-size-16 mb-1"><a href="#" class="text-dark">{{$item->name}}</a></h5>
                                        {{-- <span class="badge badge-soft-warning mb-0">توسعه دهنده Backend</span> --}}
                                    </div>
                                </div>
                                <div class="mt-3 pt-1">
                                    <p class="text-muted mb-0"><i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                        {{$item->user->mobile}}</p>
                                    <p class="text-muted mb-0 mt-2"><i
                                            class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                        {{number_format($item->tr_amount, 0, ',')}} تومان</p>
                                    <p class="text-muted mb-0 mt-2">
                                        <i class="mdi mdi-clock font-size-15 align-middle pe-2 text-primary"></i>
                                        <span dir="ltr">
                                        {{$item->created_at->diffForHumans()}}
                                        </span>
                                    </p>
                                </div>
                    
                                <div class="d-flex gap-2 pt-4">
                                    <a href="{{route('admin.chats.list', ['user_id' => $item->user->id])}}" class="btn btn-soft-primary btn-sm w-50">
                                        <i class="bx bx-user me-1"></i>گفتگوها
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                @endforeach
                
            </div>
            <!-- end row -->
            
            {{ $items->links('admin.layouts.custom-pagination') }}
            
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
     <!--  successfully modal  -->
     <div id="success-btn" class="modal fade" tabindex="-1" aria-labelledby="success-btnLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                   <div class="text-center">
                       <i class="bx bx-check-circle display-1 text-success"></i>
                       <h3 class="mt-3">کاربر با موفقیت اضافه شد</h3>
                   </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--  Extra Large modal example -->
    <div class="modal fade add-new" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">جدید اضافه کن</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                   <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="AddNew-Username">نام کاربری</label>
                                <input type="text" class="form-control" placeholder="نام کاربری را وارد کنید" id="AddNew-Username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">موقعیت</label>
                                <select class="form-select">
                                    <option selected="">موقعیت را انتخاب کنید</option>
                                    <option>توسعه دهنده Full Stack</option>
                                    <option>توسعه دهنده Frontend</option>
                                    <option>طراح UI/UX</option>
                                    <option>توسعه دهنده Backend</option>
                                </select>
                            </div>
                        </div>
                       <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="AddNew-Email">پست الکترونیک</label>
                                <input type="text" class="form-control" placeholder="ایمیل را وارد کنید" id="AddNew-Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="AddNew-Phone">تلفن</label>
                                <input type="text" class="form-control" placeholder="تلفن را وارد کنید" id="AddNew-Phone">
                            </div>
                        </div>
                   </div>
                   <div class="row mt-2">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-danger me-1" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i>لغو</button>
                        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#success-btn" id="btn-save-event"><i class="bx bx-check me-1"></i>تایید</button>
                    </div>
                </div>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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

@endsection