<?php namespace App\Http\Controllers\Labeler;

use App\Assign;
use App\Norm;
use App\Labeler;
use App\User;
use App\Proj;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AssignController extends Controller {

	public function index()
	{	
		// 防止session过期
		if (!\Auth::user()) 
		{
			\Cookie::queue('labeler', null , -1);
			return redirect('/');
		}

		$assigns = Assign::where('labeler', '=', \Auth::user()->labelerName)
					->where('claim', '!=', 1)
					->where('claim', '!=', 8)
					->get();
		
		$userId = Labeler::find(\Auth::user()->id)->belongsToUser['id'];

		// 通过查询User中的userId得到superId，再查询Norm中的superId得到使用到的规范
		$superId = Proj::find($userId)->belongsToSuper['id'];
		$norms = Norm::where('superId', '=', $superId)
					->get();

		$stateArr = [];
		$BSArr = [];
		for ($i=0; $i<count($norms); $i++)
		{
			$firstLevelArr = explode(',', $norms[$i]['firstLevel']);
			array_push($stateArr, $norms[$i]['zeroLevel']);
			array_push($BSArr, Norm::find($norms[$i]['id'])->belongsToFlash['hasBS']);
			
			for ($j=0; $j<count($firstLevelArr); $j++)
			{
				array_push($stateArr, $firstLevelArr[$j]);
				array_push($BSArr, Norm::find($norms[$i]['id'])->belongsToFlash['hasBS']);
			}
		}
		// dd($BSArr, $stateArr);
		\Cookie::queue('labeler', \Auth::user()->labelerName, 120);
		return view('labeler.assign.index', compact('assigns', 'stateArr', 'BSArr'));
	}

	public function getLabel($assignId) 
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			\Cookie::queue('labeler', null , -1);
			return redirect('/');
		}
		$assign = Assign::where('id', '=', $assignId)->first();
		$assign['labelerId'] = Labeler::where('labelerName', '=', $assign['labeler'])->first()['id'];

		$flashPathArr = [];
		$norms = Norm::where('superId', '=', $assign['userId'])->get();
		for ($i=0; $i<count($norms); $i++)
		{
			$firstLevel = explode(',', $norms[$i]['firstLevel']);
			array_push($flashPathArr, Norm::find($norms[$i]['id'])->belongsToFlash['flashPath']);
			for ($j=0; $j<count($firstLevel); $j++)
			{
				array_push($flashPathArr, Norm::find($norms[$i]['id'])->belongsToFlash['flashPath']);
			}
		}
		
		dd($flashPathArr);
		$assign['flashPath'] = $flashPathArr[$assign['state2']-1];
		
		// dd($assign);
		return view('labeler.assign.label', compact('assign'));
	}

	public function getCheck($assignId) 
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			\Cookie::queue('labeler', null , -1);
			return redirect('/');
		}
		$assign = Assign::where('id', '=', $assignId)->first();
		$assign['labelerId'] = Labeler::where('labelerName', '=', $assign['labeler'])->first()['id'];

		$flashPathArr = [];
		$norms = Norm::where('userId', '=', $assign['userId'])->get();
		for ($i=0; $i<count($norms); $i++)
		{
			$firstLevel = explode(',', $norms[$i]['firstLevel']);
			array_push($flashPathArr, Norm::find($norms[$i]['id'])->belongsToFlash['flashPathBS']);
			for ($j=0; $j<count($firstLevel); $j++)
			{
				array_push($flashPathArr, Norm::find($norms[$i]['id'])->belongsToFlash['flashPathBS']);
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