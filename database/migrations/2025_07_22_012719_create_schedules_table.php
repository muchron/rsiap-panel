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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_id');
            $table->string('day');
            $table->time('start_at');
            $table->time('end_at');
            $table->string('polyclinic_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('doctor_id')->references('username')->on('users');
            $table->foreign('polyclinic_id')->references('id')->on('polyclinics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
