<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTokenSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('user_tokens')->truncate();
        DB::table('user_tokens')->insert([
            'user_id' => 1,
            'remaining_tokens' => 100000,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
