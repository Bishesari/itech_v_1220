<?php

use App\Http\Middleware\EnsureContextIsSelected;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', EnsureContextIsSelected::class])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('roles', 'pages::role.index')->name('role.index');

});


require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
