<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class UserAuthController extends AuthController 
{
	// 登录后跳转到admin页面
	protected $redirectPath = '/admin';
	
	protected $loginPath = '/auth/admin/login';

}
