<?php namespace App\Http\Controllers\Super;

use App\Proj;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProjController extends Controller {

	public function index()
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			\Cookie::queue('super', null , -1);
			return redirect('/');
		}

		$superId = \Auth::user()->id;
		$projs = Proj::where('superId', '=', $superId)->get();
		
		\Cookie::queue('super', \Auth::user()->name, 120);
		
		return view('super.proj', compact('projs'));	
	}

	public function postProj(Request $request)
	{
		$name = $request->get('name');
		$description = $request->get('description');

		$proj = Proj::create(
			array_merge(
                ['superId'     => \Auth::user()->id],
                ['name'        => $name],
                ['description' => $description]
            ));

		return redirect()->back();
	}
}
