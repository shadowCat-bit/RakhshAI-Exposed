<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationMessageSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('conversation_messages')->truncate();
        $convs = DB::table('conversations')->get();
        foreach ($convs as $conv) {
            for ($i = 0; $i < 5; $i++) {
                DB::table('conversation_messages')->insert([
                    'conversation_id' => $conv->id,
                    'role' => ($i % 2 == 0) ? 'user' : 'assistant',
                    'content' => 'msg ' . ($i + 1),
                    'tokens' => ($i + 1) * 10,
                    'created_at' => $conv->created_at,
                    'updated_at' => $conv->updated_at
                ]);
            }
        }
    }
}
