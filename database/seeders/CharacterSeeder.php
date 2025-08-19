<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('characters')->truncate();
        DB::table('characters')->insert([
            'title' => 'معمولی',
            'role' => '',
            'priority' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('characters')->insert([
            'title' => 'معلم زبان',
            'role' => 'you are a english language teacher',
            'priority' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('characters')->insert([
            'title' => 'برنامه نویس',
            'role' => 'you are a programmer',
            'priority' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
