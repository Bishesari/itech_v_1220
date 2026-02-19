<?php

use App\Http\Middleware\EnsureContextIsSelected;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'ac'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('roles', 'pages::role.index')->name('role.index')->middleware('role:super-admin');

});


require __DIR__.'/auth.php';
require __DIR__.'/settings.php';
