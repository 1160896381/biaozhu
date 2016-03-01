<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index($class)
	{
		return view('admin.assign.index', compact('class'));
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
