<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;


Route::middleware(SetLocale::class)->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return __('messages.dashboard');
    });
});
