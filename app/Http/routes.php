<?php

Route::get('/', 'HomeController@index');

// 登录，不开放注册，注册通过超级管理员
Route::group(['prefix'=>'auth', 'namespace'=>'Auth'], function()
{
	Route::get('login', 'AuthController@getLogin');
	
	Route::post('admin/login', array('auth'=>'admin', 'uses'=>'UserAuthController@postLogin'));
	Route::post('labeler/login', array('auth'=>'labeler', 'uses'=>'LabelerAuthController@postLogin'));

	Route::get('admin/logout', array('auth'=>'admin', 'uses'=>'UserAuthController@getLogout'));
	Route::get('labeler/logout', array('auth'=>'labeler', 'uses'=>'LabelerAuthController@getLogout'));
});

Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function()
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

Route::group(['prefix'=>'labeler', 'namespace'=>'Labeler', 'auth'=>'labeler'], function()
{
	Route::get('assign', array('uses'=>'AssignController@show'));		
});

