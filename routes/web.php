<?php

Route::view('/', 'welcome');
Route::view('contact', 'contact');

include 'auth.php';
include 'front.php';

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        foreach (glob(__DIR__.'/back/*.php') as $filename) {
            include $filename;
        }
    });
