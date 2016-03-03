<?php namespace App\Http\Controllers\Admin;

use App\Norm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NormController extends Controller {

	public function typeShow()
	{
		$userId = \Auth::user()->id;
		$types = Norm::where('userId', '=', $userId)
				->where('hasNorm', '=', 1)
				->get();
		
		return view('admin.norm.type', compact('types'));
	}

	public function detailShow()
	{
		$userId = \Auth::user()->id;
		$types = Norm::where('userId', '=', $userId)
				->where('hasNorm', '=', 1)
				->get();
		
		return view('admin.norm.detail', compact('types'));
	}

	/**
	 * 修改标注类型
	 */
	public function typeChange(Request $request)
	{	
		$userId = \Auth::user()->id;
		$tab_val = $request->get('tab_val');
		$tab_arr = explode(' ', $tab_val);

		// 找到需要更改的规范进行更新
		$types = Norm::where('userId', '=', $userId)
				->where('hasNorm', '=', 1)
				->get();

		for ($i=0; $i<count($tab_arr); $i++) {
			$types[$i]->firstLevel = $tab_arr[$i];
			$types[$i]->save();
		}

		return redirect()
		        ->back()
		        ->withSuccess("请继续填写名称，否则规范不会更改！");;
	}

	/**
	 * 修改具体名称
	 */
	public function detailChange(Request $request)
	{
		dd($request->get('tab_val'));
	}	

}
