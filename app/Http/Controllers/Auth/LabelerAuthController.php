<?php namespace App\Http\Controllers\Auth;

class LabelerAuthController extends AuthController 
{
	// 登录后跳转到labeler的任务列表页面
	protected $redirectPath = '/labeler/assign';
	// 登录失败
	protected $loginPath = '/';
}
