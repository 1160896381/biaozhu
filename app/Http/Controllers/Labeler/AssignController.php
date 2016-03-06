<?php namespace App\Http\Controllers\Labeler;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function show()
	{
		// dd(\Auth::user()->labelerName);
		return view('labeler.assign.index');
	}
}