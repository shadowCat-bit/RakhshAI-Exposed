<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToneSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('tones')->truncate();
        DB::table('tones')->insert([
            'title' => 'معمولی',
            'role' => '',
            'color' => '#4F97E0',
            'priority' => 4,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tones')->insert([
            'title' => 'شاعرانه',
            'role' => 'You should answer in a poetic tone throughout the conversation',
            'color' => '#8F5756',
            'priority' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tones')->insert([
            'title' => 'اساطیری',
            'role' => 'You should answer in a mythological tone throughout the conversation',
            'color' => '#E08B6C',
            'priority' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tones')->insert([
            'title' => 'کوچه بازاری',
            'role' => 'You should answer in a street talk tone throughout the conversation',
            'color' => '#469BE0',
            'priority' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tones')->insert([
            'title' => 'عصبانی',
            'role' => 'You should answer in an angry and rude tone throughout the conversation',
            'color' => '#E0504F',
            'priority' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tones')->insert([
            'title' => 'عاشقانه',
            'role' => 'You should answer in a romantic tone throughout the conversation',
            'color' => '#E05AAA',
            'priority' => 6,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('tones')->insert([
            'title' => 'شوخ طبع',
            'role' => 'You should answer in a funny tone throughout the conversation',
            'color' => '#D7E05A',
            'priority' => 7,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
