<?php

use App\Http\Livewire\Register;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/admin')->name('home');

Route::prefix(config('filament.path'))
    ->name('filament.')
    ->group(function () {
        Route::get('/register', Register::class)->name('auth.register');
    });
