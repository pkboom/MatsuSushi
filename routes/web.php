<?php

Route::view('/', 'welcome');
Route::view('contact', 'contact');
Route::view('about', 'about');
Route::get('gallery', 'GalleryController@index');
Route::get('gallery/pages/{page}', 'GalleryController@index');

Route::view('register', 'registration.create');
Route::post('register', 'RegistrationController@store');
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store');
Route::get('logout', 'SessionsController@destory');

Route::get('admin-id/{email}', 'UserController@adminID');

Route::view('admin/uploadImage', 'admin.uploadImage');
Route::post('admin/uploadImage', 'UploadController@store');

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

Route::prefix('api')->group(function () {
	Route::get('chatroomstatus/{chatroom_user_id}', 'ChatroomController@show');
	Route::post('auth', 'AuthController@authenticate');
	Route::post('channelon', 'ChatroomController@apiOpenChannels');
	Route::post('sendmessage', 'MessageController@apiSendMessage')->middleware('auth.jwt');
	Route::post('pushtoken', 'AuthController@getPushToken')->middleware('auth.jwt');
});
	
Route::prefix('menu')->group(function () {
	Route::view('/', 'menu');	
	Route::get('category', 'MenuController@category');
	Route::get('items/{id}', 'MenuController@items');
});

