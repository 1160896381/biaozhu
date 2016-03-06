<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class LabelerAuthController extends AuthController 
{
	// 登录后跳转到labeler页面
	protected $redirectPath = '/labeler';

	protected $loginPath = '/auth/labeler/login';
}
