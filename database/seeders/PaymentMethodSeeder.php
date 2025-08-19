<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('payment_methods')->truncate();
        DB::table('payment_methods')->insert([
            'bank_name' => 'zibal',
            'bank_view_name' => 'به پرداخت بانک ملت',
            'image' => 'behpardakht.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
