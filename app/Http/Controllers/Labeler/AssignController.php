<?php namespace App\Http\Controllers\Labeler;

use App\Assign;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function show()
	{
		// dd(\Auth::user()->id);
		$assigns = Assign::where('labeler', '=', \Auth::user()->labelerName)
					->where('claim', '!=', 1)
					->where('claim', '!=', 8)
					->get();
		
		// dd($assigns);
		return view('labeler.assign.index', compact('assigns'));
	}
}