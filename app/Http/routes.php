<?php

Route::get('/', 'HomeController@index');
Route::post('/delete/cookie', 'HomeController@deleteCookie');

// 登录，不开放注册，注册通过超级管理员
Route::group(['prefix'=>'auth', 'namespace'=>'Auth'], function()
{
	Route::get('login', 'AuthController@getLogin');
	
	Route::post('admin/login', array('auth'=>'admin', 'uses'=>'UserAuthController@postLogin'));
	Route::post('labeler/login', array('auth'=>'labeler', 'uses'=>'LabelerAuthController@postLogin'));
	Route::post('super/login', array('auth'=>'super', 'uses'=>'SuperAuthController@postLogin'));

	Route::get('admin/logout', array('auth'=>'admin', 'uses'=>'UserAuthController@getLogout'));
	Route::get('labeler/logout', array('auth'=>'labeler', 'uses'=>'LabelerAuthController@getLogout'));
	Route::get('super/logout', array('auth'=>'super', 'uses'=>'SuperAuthController@getLogout'));
});

// 管理员
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'auth'=>'admin'], function()
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
	Route::post('norm/type', 'NormController@postType');
	Route::post('norm/detail', 'NormController@postDetail');
});

// 标注者
Route::group(['prefix'=>'labeler', 'namespace'=>'Labeler', 'auth'=>'labeler'], function()
{
	Route::get('assign', 'AssignController@index');
	
	Route::post('assign/label/{id}', 'AssignController@postLabel');
	Route::post('assign/check/{id}', 'AssignController@postCheck');

	Route::get('assign/label/{id}', 'AssignController@getLabel');
	Route::get('assign/check/{id}', 'AssignController@getCheck');
		
	Route::get('assign/flash/{style}/{yuliaoID}', 'AssignController@getAssistFlash');
	Route::post('assign/flash/{style}/{yuliaoID}', 'AssignController@postAssistFlash');
});

// 超级管理员
Route::group(['prefix'=>'super', 'namespace'=>'Super', 'auth'=>'super'], function()
{
	Route::get('/', 'ProjController@index');

	Route::get('proj', 'ProjController@index');
	Route::post('proj/create', 'ProjController@postProj');

	Route::get('admin', 'AdminController@index');
	Route::post('admin/create', 'AdminController@postAdmin');

	Route::get('flash', 'FlashController@index');
	Route::post('flash/create', 'FlashController@postFlash');

	Route::get('labeler', 'LabelerController@index');
	Route::get('resource', 'ResourceController@index');
	Route::get('resource/batch', 'ResourceController@batchIndex');
	Route::get('norm/type', 'NormController@typeShow');
	Route::get('norm/detail', 'NormController@detailShow');
});
