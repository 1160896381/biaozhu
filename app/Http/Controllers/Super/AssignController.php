<?php namespace App\Http\Controllers\Super;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index()
	{
		return view('super.assign.index');	
	}

}
