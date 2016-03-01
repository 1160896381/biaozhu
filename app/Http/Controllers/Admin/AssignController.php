<?php namespace App\Http\Controllers\Admin;

use App\Assign;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index(Request $request, $classId)
	{
		$userId = \Auth::user()->id;

		$assigns = Assign::where('userId', '=', $userId)
					->where('classId', '=', $classId)
					->get();
					
		return view('admin.assign.index', compact('assigns'));
	}

	public function addTask()
	{
		return view('admin.assign.index');
	}

	public function deleteTask()
	{
		return view('admin.assign.index');
	}
}
