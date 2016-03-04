<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use App\Labeler;

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
		$email = $request->get('email');
		$password = $request->get('password');

		$labeler = Labeler::where('email', '=', $email)->first();
		$salt = $labeler['salt'];
		// dd($salt);
		$passwordReal = GeneratePassword($password, $salt);
		if ($labeler['password'] == $passwordReal) {
			return redirect('/');
		} else {
			return redirect()->back();
		}
	}
}
