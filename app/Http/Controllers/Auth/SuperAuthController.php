<?php namespace App\Http\Controllers\Auth;

class SuperAuthController extends AuthController 
{
	// 登录后跳转到super的任务列表页面
	protected $redirectPath = '/labeler/assign';

	protected $loginPath = '/auth/labeler/login';
}
