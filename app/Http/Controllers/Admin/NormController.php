<?php namespace App\Http\Controllers\Admin;

use App\Norm;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NormController extends Controller {

	public function typeShow()
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			return redirect('/');
		}

		// dd(Norm::find(2)->hasOneFlash['hasNorm']);

		$userId = \Auth::user()->id;
		$types = Norm::where('userId', '=', $userId)->get();
		
		return view('admin.norm.type', compact('types'));
	}

	public function detailShow()
	{
		$userId = \Auth::user()->id;
		$types = Norm::where('userId', '=', $userId)->get();
		
		return view('admin.norm.detail', compact('types'));
	}

	/**
	 * 修改标注类型
	 */
	public function postType(Request $request)
	{	
		$userId = \Auth::user()->id;
		$tabVal = $request->get('tab_val');
		// 零级规范间以空格分割
		$tabArr = explode(' ', $tabVal);

		// 找到需要更改的规范进行更新
		$typesHasNorm = Norm::where('userId', '=', $userId)
				->where('hasNorm', '=', 1)
				->get();

		for ($i=0; $i<count($tabArr); $i++) {
			$typesHasNorm[$i]->firstLevel = $tabArr[$i];
			$typesHasNorm[$i]->save();
		}
	}

	/**
	 * 修改具体名称
	 */
	public function postDetail(Request $request)
	{
		$userId = \Auth::user()->id;
		$tabVal = $request->get('tab_val');
		// 零级规范间以“。”分割
		$tabArr = explode('。', $tabVal);

		// 获得当前规范
		$typesHasNorm = Norm::where('userId', '=', $userId)->get();

		for ($i=0; $i<count($tabArr); $i++) {
			$typesHasNorm[$i]->secondLevel = $tabArr[$i];
			$typesHasNorm[$i]->save();
		}

		// 获得最新的所有规范
		$typesNotOnlyNorm = Norm::where('userId', '=', $userId)
				->get();

		$fileName = "flash/assets/xml/label_types_" . $userId . ".xml";
	    $handle = fopen($fileName, "w");
	    $str = '<?xml version="1.0" encoding="utf-8"?><Types>';
	    $countState=1;
	    for ($i=0; $i<count($typesNotOnlyNorm); $i++) {
	        // 声明为数组
	        $array = array();
	        $Tags1 = array();
	        $Tags2 = array();
	        $Tags1 = explode(",", $typesNotOnlyNorm[$i]['firstLevel']);
	        $Tags2 = explode(",", $typesNotOnlyNorm[$i]['secondLevel']);

	        // dd($Tags2);
	        // 分组数组中第一个元素应为-1
	        array_push($array, -1);
	        // 得到二级标签中‘.’的下标，作为后来分组的依据
	        for($j=0; $j<count($Tags2); $j++)
	        {
	            if($Tags2[$j] == '.')
	            {
	                array_push($array, $j);
	            }
	        }
	        $str .= '<Layer1 layerID="'.$countState.'" label="'.$typesNotOnlyNorm[$i]['zeroLevel'].'" classid="'.$typesNotOnlyNorm[$i]['classId'].'" gf="'.$typesNotOnlyNorm[$i]['hasNorm'].'">';
	        for($j=0; $j<count($Tags1); $j++)
	        {
	            $str .= '<Layer2 layerID="'.($countState + $j + 1).'" label="'.$Tags1[$j].'">';
	            // dd($Tags2);
	            // 在分组数组中找到第i个元素，直到第i+1个元素之间的$Tags2元素即为当前一级名称下的二级名称
	            for($k=$array[$j] + 1; $k<$array[$j + 1]; $k++)
	            {
	                // 获得三层以下的结构
	                $tag3 = $Tags2[$k];
	                $str .= BuildLayer($tag3);
	            }      
	            $str .= '</Layer2>';
	        }
	        $str .= '</Layer1>';
	        $countState = $countState + count($Tags1) + 1;
	    }

	    $str .= '</Types>';
	    fwrite($handle, $str);
	    fclose($handle);

		return redirect()->back();
	}	

}
