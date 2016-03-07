<?php namespace App\Http\Controllers\Auth;

class LabelerAuthController extends AuthController 
{
	// 登录后跳转到labeler的任务列表页面
	protected $redirectPath = '/labeler/assign';

	protected $loginPath = '/auth/labeler/login';	

	public function getLogout()
	{
		$this->auth->logout();
		
		if (isset($_SESSION['labeler_session']))
		{
			unset($_SESSION['labeler_session']);
		}
		
		return redirect('/');
	}

}
