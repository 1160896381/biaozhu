<?php namespace App\Http\Controllers\Super;

use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminController extends Controller {

	public function index()
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			return redirect('/');
		}

		$superId = \Auth::user()->id;
		$admins = User::where('superId', '=', $superId)->get();
		
		return view('super.admin', compact('admins'));
	}

	public function postAdmin(Request $request)
	{
		$email = $request->get('email');
		$name = $request->get('name');
		$password = $request->get('password');
		
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
