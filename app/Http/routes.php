<?php

Route::get('/', 'HomeController@index');

// 管理员登录，不开放注册，注册通过超级管理员
Route::group(['prefix'=>'auth', 'namespace'=>'Auth'], function()
{
	Route::get('login', 'AuthController@getLogin');
	Route::post('login', 'AuthController@postLogin');
	Route::get('logout', 'AuthController@getLogout');
});

Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'auth'], function()
{
	Route::get('/', 'ResourceController@index');

	// 资源
	Route::get('resource', 'ResourceController@index');
	Route::post('resource/file', 'ResourceController@uploadFile');
	Route::delete('resource/file', 'ResourceController@deleteFile');

	// 资源，批量
	Route::get('resource/batch', 'ResourceController@batchIndex');
	Route::post('resource/batch/file', 'ResourceController@batchUploadFile');
	Route::delete('resource/batch/file', 'ResourceController@batchDeleteFile');	//--

	// 任务
	Route::get('assign/{class}', 'AssignController@index');
	Route::post('assign/task', 'AssignController@addTask');
	Route::delete('assign/task', 'AssignController@deleteTask');

	// 人员，不开放注册，注册通过管理员
	Route::get('labeler', 'LabelerController@index');
	Route::post('labeler/register', 'LabelerController@postRegister');
	Route::post('labeler/modify', 'AssignController@modifyLabeler');
	Route::post('labeler/verify', 'AssignController@verifyLabeler');
	Route::delete('labeler/delete', 'AssignController@deleteLabeler');

	// 规范
	Route::get('norm/type', 'NormController@typeShow');
	Route::get('norm/detail', 'NormController@detailShow');
	Route::post('norm/type', 'NormController@typeChange');
	Route::post('norm/detail', 'NormController@detailChange');
});

