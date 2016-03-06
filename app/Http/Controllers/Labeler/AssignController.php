<?php namespace App\Http\Controllers\Labeler;

use App\Assign;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index()
	{
		return view('labeler.index');
	}
}