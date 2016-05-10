<?php namespace App\Http\Controllers\Admin;

use App\Assign;
use App\Labeler;
use App\Norm;
use App\User;
use App\Proj;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index($classType)
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			return redirect('/');
		}
		$userId = \Auth::user()->id;

		$assigns = Assign::where('userId', '=', $userId)
					->where('classId', '=', GetClassid($classType))
					->get();

		$labelers = Labeler::where('userId', '=', $userId)
					->get();

		$projId = User::find($userId)->belongsToProj['id'];
		$superId = Proj::find($projId)->belongsToSuper['id'];

		return view('admin.assign.index', compact('assigns', 'labelers'));
	}

	public function addTask(Request $request)
	{
		$task_flag = $request->get('task_flag');	// 用于区分任务类型
		$deadTime = $request->get('deadTime');
		$claim = $request->get('claim');
		$labeler = $request->get('labeler');
		$state = $request->get('state');
		$state2 = $request->get('state2');
		$id = $request->get('assign_id');
		$classId = $request->get('class_id');

		// dd($task_flag);
		// 对于该次选择的每一个标注者，分别创建一个任务
		for ($i=0; $i<count($labeler); $i++) 
		{
			// dd($task_flag);
			if ($task_flag == 'CurrentTask') { // 更改当前任务

				Assign::where('id', '=', $id)->update(
					array_merge(
					    ['claim'    => $claim],
					    ['deadTime' => $deadTime],
					    ['labeler'  => $labeler[$i]],
					    ['state'    => $state],
					    ['state2'   => $state2]
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
			            ['labeler'    => $labeler[$i]],
			            ['initXml'    => $oldAssign['initXml']],
			            ['state'      => $state],
					    ['state2'     => $state2]
			        ));
			
			} else {
				$error = "An error occurred adding task.";
				return redirect()
				        ->back()
				        ->withErrors([$error]);
			}
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
