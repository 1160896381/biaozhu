<?php

Route::get('/', 'HomeController@index');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'auth'], function()
{
	Route::get('/', 'AdminHomeController@index');
	
	Route::get('/upload', 'UploadController@index');
	Route::post('/upload/file', 'UploadController@uploadFile');
	Route::delete('/upload/file', 'UploadController@deleteFile');
	Route::post('/upload/folder', 'UploadController@createFolder');
	Route::delete('/upload/folder', 'UploadController@deleteFolder');
	// Route::resource('pages', 'PagesController');
	// Route::resource('comments', 'CommentsController');
});

// Route::post('comment/store', 'CommentsController@store');