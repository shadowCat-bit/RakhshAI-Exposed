<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('options')->truncate();
        DB::table('options')->insert([
            'key' => 'api_key',
            'value' => 'sk-WRe4pS7DM9Jc7199OsLHT3Blb9PJrNkZrlspOEkFd6XLftbO',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
