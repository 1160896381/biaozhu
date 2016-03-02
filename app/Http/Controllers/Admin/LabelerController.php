<?php namespace App\Http\Controllers\Admin;

use App\Labeler;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LabelerController extends Controller {

	public function index()
	{
		$userId = \Auth::user()->id;
		$labelers = Labeler::where('userId', '=', $userId)->get();
		return view('admin.labeler.index', compact('labelers'));
	}

	public function register(Request $request)
	{
		$email = $request->get('email');
		$labelerName = $request->get('name');
		$password = $request->get('password');
		$password_confirmation = $request->get('password_confirmation');

		if ($password != $password_confirmation) {
			$error = "两次输入密码不一致！";

			return redirect()
			        ->back()
			        ->withErrors([$error]);
		}

		// 邮箱名不应该重复
		
		$salt = MakePassword(20);
		$password = GeneratePassword($password, $salt);

		Labeler::create(
			array_merge(
                ['userId'      => \Auth::user()->id],
                ['labelerName' => $labelerName],
                ['password'    => $password],
                ['salt'        => $salt],
                ['email' 	   => $email],
                ['verify'      => '已审核']
            ));

		return redirect()->back();
	}

}
