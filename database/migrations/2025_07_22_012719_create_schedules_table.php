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
            $table->string('slug');
            $table->string('day');
            $table->time('start_at');
            $table->time('end_at');
            $table->string('polyclinic_code');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('doctor_id')->references('doctor_id')->on('doctors');
            $table->foreign('polyclinic_code')->references('code')->on('polyclinics');
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
