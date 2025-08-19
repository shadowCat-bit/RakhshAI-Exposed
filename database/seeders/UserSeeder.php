<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'mobile' => '09123456789',
            'mobile_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'uuid' => 'f1513d65-eedc-4196-b3d5-bee7349dd995',
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
