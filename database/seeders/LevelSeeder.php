<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        Level::truncate();

        Level::create([
            'level_num' => 1,
            'from' => 1,
            'to' => 999,
            'daric_gift' => 5
        ]);
        Level::create([
            'level_num' => 2,
            'from' => 1000,
            'to' => 2999,
            'daric_gift' => 7
        ]);
        Level::create([
            'level_num' => 3,
            'from' => 3000,
            'to' => 25999,
            'daric_gift' => 10
        ]);
        Level::create([
            'level_num' => 4,
            'from' => 26000,
            'to' => 199999,
            'daric_gift' => 12
        ]);
        Level::create([
            'level_num' => 5,
            'from' => 200000,
            'to' => 999999999,
            'daric_gift' => 15
        ]);
    }
}
