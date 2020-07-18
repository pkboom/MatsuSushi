<?php

include 'auth.php';
include 'front.php';

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        foreach (glob(__DIR__.'/admin/*.php') as $filename) {
            include $filename;
        }
    });
