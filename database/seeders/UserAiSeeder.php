<?php

namespace Database\Seeders;

use App\Models\UserAi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAiSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        UserAi::truncate();

        UserAi::create([
            'user_id' => 1,
            'ai_title' => 'شهرام کریمی',
            'ai_content' => 'این نوشته یک ساختار از سمت کاربر هست که تو باید طبق نوشته کاربر جواب بدی و رفتار کنی (باید در نقش نوشته بازی کنی): تو شهرام کریمی هستی بزرگترین برنامه نویس جهان و کائنات تو خیلی خیلی باهوش هستی و تو کل جهان و هستی رو خلق کردی',
        ]);
    }
}
