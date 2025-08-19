<?php

namespace Database\Seeders;

use App\Models\Point;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        Point::truncate();

        Point::create([
            'type' => 'register',
            'title' => 'ثبت نام',
            'description' => 'ثبت نام توضیحات',
            'value' => 500
        ]);

        Point::create([
            'type' => 'install_app',
            'title' => 'نصب اپ',
            'description' => 'توضیحات نصب اپ',
            'value' => 580
        ]);

        Point::create([
            'type' => 'purchase_package_1',
            'title' => 'خرید پکیج سهراب',
            'description' => 'خرید پکیج سهراب',
            'value' => 1000
        ]);

        Point::create([
            'type' => 'purchase_package_2',
            'title' => 'خرید پکیج سیندخت',
            'description' => 'خرید پکیج سیندخت',
            'value' => 3250
        ]);

        Point::create([
            'type' => 'purchase_package_3',
            'title' => 'خرید پکیج سیمرغ',
            'description' => 'خرید پکیج سیمرغ',
            'value' => 13000
        ]);

        Point::create([
            'type' => 'daily_app_visit',
            'title' => 'بازدید روزانه اپ',
            'description' => 'بازدید روزانه اپ',
            'value' => 5
        ]);
    }
}
