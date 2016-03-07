<?php namespace App\Http\Controllers\Labeler;

use App\Assign;
use App\Norm;
use App\Labeler;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index()
	{	
		$assigns = Assign::where('labeler', '=', \Auth::user()->labelerName)
					->where('claim', '!=', 1)
					->where('claim', '!=', 8)
					->get();
		
		$userId = Labeler::find(\Auth::user()->id)
					->user['id'];
		
		$norms = Norm::where('userId', '=', $userId)
					->get();
		
		$stateArr = [];
		for ($i=0; $i<count($norms); $i++)
		{
			$firstLevelArr = explode(',', $norms[$i]['firstLevel']);
			array_push($stateArr, $norms[$i]['zeroLevel']);
			for ($j=0; $j<count($firstLevelArr); $j++)
			{
				array_push($stateArr, $firstLevelArr[$j]);
			}
		}
		
		return view('labeler.assign.index', compact('assigns', 'stateArr'));
	}

	public function getLabel($id) 
	{
		
		return view('labeler.assign.label');
	}

	public function getCheck($id) 
	{
		// dd($id);
		return view('labeler.assign.check');
	}
}