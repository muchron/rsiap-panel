<?php

use App\Filament\Resources\DoctorResource\Api\DoctorApiService;
use App\Filament\Resources\DoctorResource\Api\Handlers\PaginationHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');