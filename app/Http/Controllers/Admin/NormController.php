<?php namespace App\Http\Controllers\Admin;

use App\Norm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NormController extends Controller {

	public function typeShow()
	{
		$userId = \Auth::user()->id;
		$types = Norm::where('userId', '=', $userId)->get();
		return view('admin.norm.type', compact('types'));
	}

	public function detailShow()
	{
		return view('admin.norm.detail');
	}

	public function typeChange()
	{

	}

	public function detailChange()
	{

	}	

}
