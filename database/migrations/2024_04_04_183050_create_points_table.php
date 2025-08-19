<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['register', 'install_app', 'purchase_package_1', 'purchase_package_2', 'purchase_package_3', 'daily_app_visit']);
            $table->string('title', 100)->unique();
            $table->string('description', 250)->unique();
            $table->unsignedInteger('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('points');
    }
};
