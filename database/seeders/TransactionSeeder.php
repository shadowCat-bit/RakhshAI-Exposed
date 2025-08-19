<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('transactions')->truncate();
        DB::table('transactions')->insert([
            'user_id' => 1,
            'tr_type' => 'buy package',
            'payment_method_id' => 1,
            'tr_amount' => 50000,
            'tr_status' => 'success',
            'package_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('transactions')->insert([
            'user_id' => 1,
            'tr_type' => 'charge wallet',
            'payment_method_id' => 2,
            'tr_amount' => 233000,
            'tr_status' => 'success',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
