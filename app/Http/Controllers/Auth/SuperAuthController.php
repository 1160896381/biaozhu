<?php namespace App\Http\Controllers\Auth;

class SuperAuthController extends AuthController 
{
	// 登录后跳转到super的任务列表页面
	protected $redirectPath = '/super';
	// 登录失败
	protected $loginPath = '/';

	public function getLogout()
	{
		\Cookie::queue('super', null , -1);
	    \Auth::logout();
	    return redirect('/');
	}
}
