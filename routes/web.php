<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversionController;
use CloudConvert\Laravel\CloudConvertWebhooksController;

Route::get('/', fn () => redirect('/login'))->name('welcome');

Route::group([
    'middleware' => ['auth:scorch', 'verified'],
], function (): void {
    Route::get('/home', [ConversionController::class, 'index'])->name('home');
    Route::post('/convert', [ConversionController::class, 'store'])->name('conversions.store');
    Route::get('/convert/{conversion}', [ConversionController::class, 'show'])->name('conversions.show');
});

Route::post('/webhook/cloudconvert', [CloudConvertWebhooksController::class, '__invoke']);
