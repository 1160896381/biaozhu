<?php namespace App\Http\Controllers\Super;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LabelerController extends Controller {

	public function index()
	{
		return view('super.labeler');	
	}

}