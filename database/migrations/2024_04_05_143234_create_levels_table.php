<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('level_num');
            $table->unsignedInteger('from');
            $table->unsignedInteger('to');
            $table->unsignedInteger('daric_gift');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('levels');
    }
};
