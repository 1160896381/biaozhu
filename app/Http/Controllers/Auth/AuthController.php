<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {

	use AuthenticatesAndRegistersUsers;

	protected $redirectTo = '/admin';

	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function postLabelerLogin(Request $request) 
	{
		// dd($request);
		// dd($this->auth);
		dd(\Auth::currentType());
		// dd(\Auth::type('labeler')->check());
	}
}
