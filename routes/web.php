<?php

Route::get('/', 'MainController@index');
Route::get('/menu', 'MenuController@index');
Route::get('/contact', 'ContactController@index');
Route::get('/about', 'AboutController@index');
Route::get('/gallery', 'GalleryController@index');
Route::get('/gallery/pages/{page}', 'GalleryController@index');
Route::get('/menu', 'MenuController@index');
Route::get('/cart', 'CartController@index');

Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');

Route::get('/admin-id/{email}', 'UserController@adminID');

// Route::get('/login', 'SessionsController@create');
// named route
// name: login
// action: SessionsController@create
Route::get('/login', [ 'as' => 'login', 'uses' => 'SessionsController@create']);
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destory');

Route::get('/admin/uploadImage', 'UploadController@select');
Route::post('/admin/uploadImage', 'UploadController@store');

Route::post('/messages', 'MessageController@create');
Route::get('/lastmessages/{chatroomID}', 'MessageController@lastmessages');
Route::get('/admin/messages/{id}', 'MessageController@adminShow');
Route::get('/admin/chat', 'MessageController@adminChat')->name('home');

Route::get('/chatroom/count/{id}', 'ChatroomController@chatroomCount');
Route::get('/chatroom/{id}', 'ChatroomController@show');
Route::get('/getchatroom', 'ChatroomController@getchatroom');
Route::post('/leavechatroom/{id}', 'ChatroomController@leavechatroom');
Route::get('/channelon', 'ChatroomController@channelon');
Route::post('/channelon', 'ChatroomController@openChannels');
Route::get('/isfull', 'ChatroomController@isfull');

Route::prefix('api')->group(function () {
	Route::post('auth', 'AuthController@authenticate');
	Route::post('channelon', 'ChatroomController@apiOpenChannels');
	Route::post('sendmessage', 'MessageController@apiSendMessage');
	Route::post('pushtoken', 'AuthController@getPushToken');
	Route::get('chatroomstatus/{adminId}', 'ChatroomController@apiGetChatroomStatus');
});