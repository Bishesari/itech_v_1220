<?php
use Illuminate\Support\Facades\Route;

Route::livewire('register', 'pages::auth.register')->name('register');
Route::livewire('/select-context', 'pages::auth.context-select')->middleware('auth')->name('context.select');


