<?php

Route::get('/', 'HomeController@index');

// 登录注册
Route::group(['prefix'=>'auth', 'namespace'=>'Auth'], function()
{
	Route::get('register', 'AuthController@getRegister');
	Route::post('register', 'AuthController@postRegister');
	Route::get('login', 'AuthController@getLogin');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
});

// 资源管理
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'auth'], function()
{
	Route::get('/', 'ResourceController@index');

	Route::get('resource', 'ResourceController@index');
	Route::post('resource/file', 'ResourceController@uploadFile');
	Route::delete('resource/file', 'ResourceController@deleteFile');

	Route::get('resource/batch', 'ResourceController@batchIndex');
	Route::post('resource/batch/file', 'ResourceController@batchUploadFile');
	Route::delete('resource/batch/file', 'ResourceController@batchDeleteFile');	//--

	Route::get('assign/{class}', 'AssignController@index');
	Route::post('assign/task', 'AssignController@addTask');
	Route::delete('assign/task', 'AssignController@deleteTask');
});

