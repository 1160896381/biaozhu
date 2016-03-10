<?php namespace App\Http\Controllers\Super;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NormController extends Controller {

	public function typeShow()
	{
		return view('super.norm.type');	
	}

	public function detailShow()
	{
		return view('super.norm.detail');	
	}
}
