<?php
Route::get('/', 'MainController@index');
Route::get('/contact', 'ContactController@index');
Route::get('/about', 'AboutController@index');
Route::get('/gallery', 'GalleryController@index');
Route::get('/gallery/pages/{page}', 'GalleryController@index');

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
Route::post('/getchatroom', 'ChatroomController@getChatroom');
Route::post('/leavechatroom/{id}', 'ChatroomController@leaveChatroom');
Route::get('/channelon', 'ChatroomController@channelon');
Route::get('/isfull', 'ChatroomController@isfull');

Route::prefix('chat')->group(function () {
	Route::post('main', 'ChatroomController@toggleMainButon');
});

Route::prefix('cart')->group(function () {
	Route::get('/', 'CartController@index');
	Route::get('payment', 'CartController@payment');
	
});

Route::prefix('api')->group(function () {
	Route::post('auth', 'AuthController@authenticate');
	Route::post('channelon', 'ChatroomController@apiOpenChannels');
	Route::post('sendmessage', 'MessageController@apiSendMessage');
	Route::post('pushtoken', 'AuthController@getPushToken');
	Route::get('chatroomstatus/{adminId}', 'ChatroomController@apiGetChatroomStatus');
});
	
Route::prefix('menu')->group(function () {
	Route::get('/', 'MenuController@index');	
	Route::get('category', 'MenuController@category');
	Route::get('items/{id}', 'MenuController@items');
});

