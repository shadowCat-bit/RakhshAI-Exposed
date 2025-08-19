<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('title', 500);
            $table->text('prompt');
            $table->text('img');
            $table->string('final_txt', 500);
            $table->enum('size', ['small', 'medium', 'large']);
            $table->boolean('public_show')->default(false)->index();
            $table->boolean('is_pinned')->default(false);
            $table->tinyInteger('version')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('images');
    }
};
