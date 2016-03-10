<?php namespace App\Http\Controllers\Super;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ResourceController extends Controller {

	public function index()
	{
		return view('super.resource.index');	
	}

	public function batchIndex()
	{
		return view('super.resource.batch');	
	}

}
