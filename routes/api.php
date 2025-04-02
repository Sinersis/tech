<?php

use App\Http\Controllers\api\v1\RowController;
use App\Http\Controllers\api\v1\UploadController;
use Illuminate\Support\Facades\Route;

Route::post('upload', [UploadController::class, 'upload'])->middleware('basic.auth');
Route::group(['prefix' => 'rows'], function () {
   Route::get('/', [RowController::class, 'index']);
});
