<?php

Route::get('/', 'HomeController@index');

Route::group(['prefix'=>'auth', 'namespace'=>'Auth'], function()
{
	Route::get('register', 'AuthController@getRegister');
	Route::post('register', 'AuthController@postRegister');
	Route::get('login', 'AuthController@getLogin');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
});

Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'auth'], function()
{
	Route::get('/', 'ResourcesController@index');

	Route::get('resource', 'ResourcesController@index');
	Route::post('resource/file', 'ResourcesController@uploadFile');
	Route::delete('resource/file', 'ResourcesController@deleteFile');
});

