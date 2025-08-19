<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('conversations')->truncate();
        for ($i = 0; $i < 5; $i++) {
            DB::table('conversations')->insert([
                'user_id' => 1,
                'title' => 'my new conversation ' . ($i + 1),
                'total_tokens' => 100 * ($i + 1),
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i)
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            DB::table('conversations')->insert([
                'user_id' => 1,
                'title' => 'my V2 conversation ' . ($i + 1),
                'total_tokens' => 100 * ($i + 1),
                'version' => 2,
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i)
            ]);
        }
    }
}
