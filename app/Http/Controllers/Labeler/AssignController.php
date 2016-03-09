<?php namespace App\Http\Controllers\Labeler;

use App\Assign;
use App\Norm;
use App\Labeler;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index()
	{	
		// 防止session过期
		if (!\Auth::user()) 
		{
			return redirect('/');
		}

		$assigns = Assign::where('labeler', '=', \Auth::user()->labelerName)
					->where('claim', '!=', 1)
					->where('claim', '!=', 8)
					->get();
		
		// 模型Labeler中的userId对应模型User中的id，通过调用user()方法得到当前标注者对应的管理员id
		$userId = Labeler::find(\Auth::user()->id)
					->user['id'];
		
		// 通过查询模型Norm中的userId得到使用到的规范
		$norms = Norm::where('userId', '=', $userId)
					->get();
		
		$stateArr = [];
		$BSArr = [];
		for ($i=0; $i<count($norms); $i++)
		{
			$firstLevelArr = explode(',', $norms[$i]['firstLevel']);
			array_push($stateArr, $norms[$i]['zeroLevel']);
			array_push($BSArr, $norms[$i]['hasBS']);
			
			for ($j=0; $j<count($firstLevelArr); $j++)
			{
				array_push($stateArr, $firstLevelArr[$j]);
				array_push($BSArr, $norms[$i]['hasBS']);
			}
		}
		// dd($BSArr, $stateArr);
		return view('labeler.assign.index', compact('assigns', 'stateArr', 'BSArr'));
	}

	public function getLabel($assignId) 
	{
		$assign = Assign::where('id', '=', $assignId)->first();
		$assign['labelerId'] = Labeler::where('labelerName', '=', $assign['labeler'])->first()['id'];

		$flashPathArr = [];
		$norms = Norm::where('userId', '=', $assign['userId'])->get();
		for ($i=0; $i<count($norms); $i++)
		{
			$firstLevel = explode(',', $norms[$i]['firstLevel']);
			array_push($flashPathArr, $norms[$i]['flashPath']);
			for ($j=0; $j<count($firstLevel); $j++)
			{
				array_push($flashPathArr, $norms[$i]['flashPath']);
			}
		}
		
		$assign['flashPath'] = $flashPathArr[$assign['state2']-1];
		
		// dd($assign);
		return view('labeler.assign.label', compact('assign'));
	}

	public function getCheck($assignId) 
	{
		$assign = Assign::where('id', '=', $assignId)->first();
		$assign['labelerId'] = Labeler::where('labelerName', '=', $assign['labeler'])->first()['id'];

		$flashPathArr = [];
		$norms = Norm::where('userId', '=', $assign['userId'])->get();
		for ($i=0; $i<count($norms); $i++)
		{
			$firstLevel = explode(',', $norms[$i]['firstLevel']);
			array_push($flashPathArr, $norms[$i]['flashPathBS']);
			for ($j=0; $j<count($firstLevel); $j++)
			{
				array_push($flashPathArr, $norms[$i]['flashPathBS']);
			}
		}
		$assign['flashPath'] = $flashPathArr[$assign['state2']-1];

		return view('labeler.assign.check', compact('assign'));
	}

	public function getAssistFlash($style, $yuliaoID)
	{
		$assign = Assign::where('id', '=', $yuliaoID)->first();

		if ($style == 1) {
			// 返回改动后的xml
			echo $assign['xml'];

		} else if ($style == 2) {
			// 返回初始xml
			echo $assign['initXml'];

		}  else if ($style == 7) {
			
			Assign::where('id', '=', $yuliaoID)->update(
				array_merge(
				    ['finishTime' => date("Y-m-d H:i:s")],
				    ['claim'      => 7]
				));
		}
	}

	public function postAssistFlash($style, $yuliaoID, Request $request)
	{
		$assign = Assign::where('id', '=', $yuliaoID)->first();

		$postData = $request->getContent();
		
		if ($style == 3) { // 只保存，不提交
		
			Assign::where('id', '=', $yuliaoID)->update(
				array_merge(
				    ['xml'    => $postData]
				));

		} else if ($style == 4) { // 提交
			
			Assign::where('id', '=', $yuliaoID)->update(
				array_merge(
				    ['xml'        => $postData],
				    ['finishTime' => date("Y-m-d H:i:s")],
				    ['claim'      => 7]
				));			

		} else if ($style == 5) { // 上传图片

			// dd($request);
			$fileName = preg_replace("/\+/", "\/", $yuliaoID);
			$file = fopen($fileName, "w");
			fwrite($file, $postData);
			fclose($file);

		} else if ($style == 6) {

			Assign::where('id', '=', $yuliaoID)->update(
				array_merge(
				    ['initXml'    => $postData]
				));

		}
	}
}