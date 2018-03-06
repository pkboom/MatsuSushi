<?php

Route::view('/', 'welcome');
Route::view('contact', 'contact');
Route::view('about', 'about');

Route::view('register', 'registration.create');
Route::post('register', 'RegistrationController@store');
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store');
Route::get('logout', 'SessionsController@destory');

Route::get('admin-id/{email}', 'UserController@adminID');

Route::post('messages', 'MessageController@create');
Route::get('lastmessages/{chatroomID}', 'MessageController@lastmessages');
Route::get('admin/messages/{id}', 'MessageController@adminShow');
Route::view('admin/chat', 'admin.chat')->name('home');

Route::get('chatroom/count/{chatroom_user_id}', 'ChatroomController@chatroomCount');
Route::get('chatroom/{chatroom_user_id}', 'ChatroomController@show');

Route::post('getchatroom', 'ChatroomController@getChatroom');
Route::post('leavechatroom/{id}', 'ChatroomController@leaveChatroom');
Route::get('channelon', 'ChatroomController@channelon');
Route::get('isfull', 'ChatroomController@isfull');

Route::prefix('chat')->group(function () {
    Route::post('main', 'ChatroomController@toggleMainButon');
});

Route::view('cart', 'cart.cart');
Route::view('cart/payment', 'cart.payment');

Route::get('api/chatroomstatus/{chatroom_user_id}', 'ChatroomController@show');
Route::post('api/auth', 'AuthController@authenticate');
Route::post('api/channelon', 'ChatroomController@apiOpenChannels');
Route::post('api/sendmessage', 'MessageController@apiSendMessage')->middleware('auth.jwt');
Route::post('api/pushtoken', 'AuthController@getPushToken')->middleware('auth.jwt');

Route::view('menu', 'menu.menu');
Route::get('menu/categories', 'CategoryController@index');
Route::post('menu/categories', 'CategoryController@store')->middleware('auth');
Route::patch('menu/categories/{category}', 'CategoryController@update')->middleware('auth');
Route::delete('menu/categories/{category}', 'CategoryController@destroy')->middleware('auth');
Route::get('menu/categories/{category}', 'CategoryController@show');
Route::post('menu/categories/{category}', 'MenuController@store')->middleware('auth');
Route::patch('menu/categories/{category}/items/{item}', 'MenuController@update')->middleware('auth');
Route::delete('menu/categories/{category}/items/{item}', 'MenuController@destroy')->middleware('auth');

Route::get('gallery', 'ImageController@index');
Route::view('upload', 'images.upload');
Route::post('upload', 'ImageController@store')->middleware('auth');
