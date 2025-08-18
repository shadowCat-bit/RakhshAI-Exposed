@extends('admin.layouts.public', ['title' => 'فروش بازه ای'])

@section('content')

<div class="main-content">
    
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <form method="GET"  id="date_range_form">
                    <div class="col-lg-4">
                        <label for="from_date">از تاریخ</label>
                        <input type="date" class="form-control" id="from_date" value="{{$fromDate}}" name="from_date" required>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <label for="to_date">تا تاریخ</label>
                        <input type="date" class="form-control" id="to_date" value="{{$toDate}}" name="to_date" required>
                    </div>
                    <div class="col-lg-4 mt-4">
                        <input type="submit" class="btn btn-primary" value="تایید" style="width: 100%">
                    </div>
                </form>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="form-group" style="font-size: 22px">
                        <label for="total_buy">جمع فروش :</label>
                        <span id="total_buy" style="color: blueviolet">{{$totalSell ?? 0}} تومان</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="font-size: 22px">
                        <label for="total_tokens">جمع توکن ها (زال 1) :</label>
                        <span id="total_tokens" style="color: blueviolet">{{$info['ZALV1'] ?? 0}}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="font-size: 22px">
                        <label for="total_tokens">جمع توکن ها (زال 2) :</label>
                        <span id="total_tokens" style="color: blueviolet">{{$info['ZALV2'] ?? 0}}</span>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-4">
                    <div class="form-group" style="font-size: 22px">
                        <label for="total_tokens">تعداد عکس ها (شهرزاد 1) :</label>
                        <span id="total_tokens" style="color: blueviolet">{{$info['SHZ1'] ?? 0}}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="font-size: 22px">
                        <label for="total_tokens">تعداد عکس ها (شهرزاد 2) :</label>
                        <span id="total_tokens" style="color: blueviolet">{{$info['SHZ2'] ?? 0}}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group" style="font-size: 22px">
                        <label for="total_tokens">تعداد ثبت نام :</label>
                        <span id="total_tokens" style="color: blueviolet">{{$info['USERS'] ?? 0}}</span>
                    </div>
                </div>
            </div>
            <!-- end row -->

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

@endsection
