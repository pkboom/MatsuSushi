<?php

use App\Http\Controllers\KakaoController;
use Illuminate\Support\Facades\Route;

Route::get('kakao/login', [KakaoController::class, 'login']);
Route::get('kakao/redirect', [KakaoController::class, 'redirect']);
Route::get('kakao/send', [KakaoController::class, 'send']);
