<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Nifas', 'Anak', 'Umum'])->default('Umum');
            $table->string('class')->nullable();
            $table->string('slug')->unique();
            $table->text('desc')->nullable();
            $table->integer('price');
            $table->string('image')->default('default-kamar.jpg');
            $table->json('features');
            $table->string('color_theme')->default('blue');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room');
    }
};
