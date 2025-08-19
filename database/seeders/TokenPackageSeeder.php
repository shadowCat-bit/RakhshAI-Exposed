<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenPackageSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('token_packages')->truncate();
        DB::table('token_packages')->insert([
            'title' => 'طرح سهراب',
            'description' => 'حساب شما به میزان 35 هزار سکه داریک شارژ می شود و می توانید 35 هزار کلمه پاسخ از رخشای دریافت کنید.',
            'main_price' => 50000,
            'price' => 50000,
            'price_text' => '50 هزار تومان',
            'tokens' => 35000,
            'image' => 'sohrab.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('token_packages')->insert([
            'title' => 'طرح سیندخت',
            'description' => 'حساب شما به میزان 170 هزار سکه داریک شارژ می شود و می توانید 170 هزار کلمه پاسخ از رخشای دریافت کنید.',
            'main_price' => 150000,
            'price' => 150000,
            'price_text' => '150 هزار تومان',
            'tokens' => 170000,
            'image' => 'sindokht.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('token_packages')->insert([
            'title' => 'طرح سیمرغ ',
            'description' => 'حساب شما به میزان "یک ملیون" سکه داریک شارژ می شود و می توانید "یک ملیون" کلمه پاسخ از رخشای دریافت کنید.',
            'main_price' => 500000,
            'price' => 500000,
            'price_text' => '500 هزار تومان',
            'tokens' => 1000000,
            'image' => 'simorgh.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
