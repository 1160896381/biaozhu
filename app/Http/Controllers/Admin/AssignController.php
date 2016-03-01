<?php namespace App\Http\Controllers\Admin;

use App\Assign;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index($classId)
	{
		$userId = \Auth::user()->id;

		$assigns = Assign::where('userId', '=', $userId)
					->where('classId', '=', $classId)
					->get();

		return view('admin.assign.index', compact('assigns'));
	}

	public function addTask(Request $request)
	{
		$task_flag = $request->get('task_flag');
		$deadTime = $request->get('deadTime');
		$claim = $request->get('claim');
		$labeler = $request->get('labeler');
		$id = $request->get('assign_id');
		$classId = $request->get('class_id');

		// dd($task_flag);
		if ($task_flag == 'CurrentTask') { // 更改当前任务

			Assign::where('id', '=', $id)->update(
				array_merge(
				    ['claim'      => $claim],
				    ['deadTime'   => $deadTime],
				    ['labeler'    => $labeler]
				));

		} else if ($task_flag == 'NewTask') { // 创建新任务

			$oldAssign = Assign::where('id', '=', $id)->get()[0];
			// dd($oldAssign);
		    Assign::create(
		        array_merge(
		            ['classId'    => $classId],
		            ['userId'     => \Auth::user()->id],
		            ['title'      => $oldAssign['title']],
		            ['claim'      => $claim],
		            ['finishTime' => null],
		            ['deadTime'   => $deadTime],
		            ['labeler'    => $labeler],
		            ['initXml'    => $oldAssign['initXml']]
		        ));
		
		} else {
			$error = "An error occurred adding task.";
			return redirect()
			        ->back()
			        ->withErrors([$error]);
		}
		
		return redirect()
	            ->back()
	            ->withSuccess("");
	}

	public function deleteTask()
	{
		return view('admin.assign.index');
	}
}
