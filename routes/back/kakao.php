<?php

use App\Http\Controllers\KakaoController;

Route::get('kakao/login', [KakaoController::class, 'login']);
Route::get('kakao/redirect', [KakaoController::class, 'redirect']);
Route::get('kakao/send', [KakaoController::class, 'send']);
