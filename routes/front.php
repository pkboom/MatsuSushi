<?php

use App\Events\OrderPlaced;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MenuBookController;
use App\Http\Controllers\OrderCompleteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReceiveOnlineOrderController;
use App\Http\Controllers\StartYourOrderController;
use App\Http\Controllers\ThankyouController;
use Illuminate\Support\Facades\Response;

Route::view('/', 'home');

Route::get('menu', MenuBookController::class);

Route::get('gallery', GalleryController::class);

Route::get('order', OrderController::class);

Route::get('cart', CartController::class)->name('cart');

Route::get('start/your/order', [StartYourOrderController::class, 'create']);
Route::post('start/your/order', [StartYourOrderController::class, 'store']);

Route::get('checkout', [CheckoutController::class, 'create']);
Route::post('checkout', [CheckoutController::class, 'checkout']);

Route::get('order/complete/{paymentIntentId}', OrderCompleteController::class);

Route::get('thankyou/{transaction}', ThankyouController::class)->name('thankyou');

Route::get('receive/online/order', ReceiveOnlineOrderController::class);

Route::get('message/test', function () {
    event(new OrderPlaced('test'));

    return Response::json('ok');
});
