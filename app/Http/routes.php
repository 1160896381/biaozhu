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
	Route::get('/', 'ResourceController@index');

	Route::get('resource', 'ResourceController@index');
	Route::post('resource/file', 'ResourceController@uploadFile');
	Route::delete('resource/file', 'ResourceController@deleteFile');
	// Route::resource('pages', 'PagesController');
	// Route::resource('comments', 'CommentsController');
});

// Route::post('comment/store', 'CommentsController@store');