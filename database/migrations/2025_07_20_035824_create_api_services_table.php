<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_services', function (Blueprint $table) {
            $table->id();
            $table->integer('cons_id')->unique();
            $table->string('api_key')->unique();
            $table->string('project');

            $table->string('request_by');
            $table->string('created_by');


            $table->foreign('request_by')->references('username')->on('users');
            $table->foreign('created_by')->references('username')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_services');
    }
};
