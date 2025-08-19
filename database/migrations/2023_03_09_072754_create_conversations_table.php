<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('title');
            $table->integer('total_tokens')->unsigned()->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->bigInteger('tone_id')->unsigned()->default(1);
            $table->bigInteger('character_id')->unsigned()->default(1);
            $table->bigInteger('ai_id')->unsigned()->nullable();
            $table->tinyInteger('version')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('conversations');
    }
};
