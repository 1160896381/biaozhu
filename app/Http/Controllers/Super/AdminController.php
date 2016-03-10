<?php namespace App\Http\Controllers\Super;

use App\User;
use App\Proj;

use App\Http\Requests;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function index()
	{
		// 防止session过期
		if (!\Auth::user()) 
		{	
			\Cookie::queue('super', null , -1);
			return redirect('/');
		}

		$superId = \Auth::user()->id;
		$admins = User::where('superId', '=', $superId)->get();
		$projs = Proj::where('superId', '=', $superId)->get();

		return view('super.admin', compact('admins', 'projs'));
	}

	public function postAdmin(AdminRegisterRequest $request)
	{
		$email = $request->get('email');
		$name = $request->get('name');
		$password = $request->get('password');
		$projId = $request->get('projId');

		$password = \Hash::make($password);
		
		$admin = User::create(
			array_merge(
                ['superId'   => \Auth::user()->id],
                ['projId'    => $projId],
                ['name'      => $name],
                ['password'  => $password],
                ['email' 	 => $email]
            ));

		return redirect()->back();
	}

}
