@extends('admin.layouts.public', ['title' => 'داشبورد'])

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5">
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="avatar">
                                                    <div class="avatar-title rounded bg-primary bg-gradient">
                                                        <i data-eva="shopping-bag" class="fill-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h4 class="text-truncate mb-1">{{$sumPurchased}} تومان</h4>
                                                    <p class="text-truncate text-muted mb-0">کل فروش</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="avatar">
                                                    <div class="avatar-title rounded bg-primary bg-gradient">
                                                        <i data-eva="shopping-bag" class="fill-white"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h4 class="text-truncate mb-1">{{$userCount}}</h4>
                                                    <p class="text-truncate text-muted mb-0">تعداد کاربران</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection