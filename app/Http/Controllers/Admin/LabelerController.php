<?php namespace App\Http\Controllers\Admin;

use App\Labeler;

use App\Http\Requests;
use App\Http\Requests\LabelerRegisterRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LabelerController extends Controller {

	public function index()
	{
		$userId = \Auth::user()->id;
		$labelers = Labeler::where('userId', '=', $userId)->get();
		return view('admin.labeler.index', compact('labelers'));
	}

	public function postRegister(LabelerRegisterRequest $request)
	{
		$email = $request->get('email');
		$labelerName = $request->get('labelerName');
		$password = $request->get('password');

		// $salt = MakePassword(20);
		// $password = GeneratePassword($password, $salt);
		$password = \Hash::make($password);
		
		$labeler = Labeler::create(
			array_merge(
                ['userId'      => \Auth::user()->id],
                ['labelerName' => $labelerName],
                ['password'    => $password],
                ['email' 	   => $email]
            ));

		return redirect()->back();
	}

}
