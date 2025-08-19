<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            UserSeeder::class,
            // ConversationSeeder::class,
            // ConversationMessageSeeder::class,
            TokenPackageSeeder::class,
            UserTokenSeeder::class,
            PaymentMethodSeeder::class,
            // TransactionSeeder::class,
            OptionSeeder::class,
            ToneSeeder::class,
            CharacterSeeder::class,
            UserAiSeeder::class,
            PointSeeder::class,
            LevelSeeder::class,
        ]);
    }
}
