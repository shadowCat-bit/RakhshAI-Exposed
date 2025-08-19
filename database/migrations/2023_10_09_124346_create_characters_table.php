<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('role', 500);
            $table->string('icon', 250)->nullable();
            $table->string('color', 10)->nullable();
            $table->boolean('priority');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('characters');
    }
};
