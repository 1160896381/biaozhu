<?php namespace App\Http\Controllers\Super;

use App\Norm;
use App\Flash;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NormController extends Controller {

	public function firstNormShow()
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			\Cookie::queue('super', null , -1);
			return redirect('/');
		}

		$superId = \Auth::user()->id;
		// 得到所有FLASH面板
		$flashes = Flash::get();
		
		// 构造一级规范
		$zeroLevel = array();
		for ($i=0; $i<count($flashes); $i++)
		{
			$normsArr = Norm::where('flashId', '=', $flashes[$i]['id'])->get();
			$normsArr2 = array();
			// 获得与flashId相同的规范
			for ($j=0; $j<count($normsArr); $j++)
			{
				if (!in_array($normsArr[$j]['zeroLevel'], $normsArr2))
				{
					array_push($normsArr2, $normsArr[$j]['zeroLevel']);
				}
			}
			// dd($normsArr2);
			
			// 转化为字符串	
			$normsArr2 = implode(',', $normsArr2);
			
			array_push($zeroLevel, $normsArr2);
		}
		
		return view('super.norm.first', compact('flashes', 'zeroLevel'));
	}

	public function secondNormShow()
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			\Cookie::queue('super', null , -1);
			return redirect('/');
		}

		$superId = \Auth::user()->id;

		$norms = Norm::where('superId', '=', $superId)->get();
		$first = array();
		// 获得与一级规范对应的flashId
		$flashIds = array();
		$firstIds = array();
		for ($i=0; $i<count($norms); $i++)
		{
			if (!array_key_exists($norms[$i]['zeroLevel'], $first))
			{
				// 构成关联数组，哈希
				$first[$norms[$i]['zeroLevel']] = $norms[$i]['firstLevel'];
				array_push($flashIds, $norms[$i]['flashId']);
				array_push($firstIds, $norms[$i]['id']);
			}
			else 
			{
				$first[$norms[$i]['zeroLevel']] = $first[$norms[$i]['zeroLevel']] 
												. ',' 
												. $norms[$i]['firstLevel'];	
			}
		}
		$firstKeys = array_keys($first);
		// dd($firstKeys);
		return view('super.norm.second', compact('flashIds', 'firstIds', 'firstKeys', 'first'));
	}

	public function thirdNormShow()
	{
		// 防止session过期
		if (!\Auth::user()) 
		{
			\Cookie::queue('super', null , -1);
			return redirect('/');
		}

		$superId = \Auth::user()->id;
		$norms = Norm::where('superId', '=', $superId)->get();
		$first = array();
		$second = array();
		$firstIds = array();
		for ($i=0; $i<count($norms); $i++)
		{
			// 拼接二级字符串
			if (array_key_exists($norms[$i]['zeroLevel'], $first))
			{
				$first[$norms[$i]['zeroLevel']] = $first[$norms[$i]['zeroLevel']] 
												. ',' 
												. $norms[$i]['firstLevel'];								

				$second[$norms[$i]['zeroLevel']] = $second[$norms[$i]['zeroLevel']] 
													. '.' 
													. $norms[$i]['secondLevel'];
			}
			else 
			{
				// 构成关联数组，哈希
				$first[$norms[$i]['zeroLevel']] = $norms[$i]['firstLevel'];
				$second[$norms[$i]['zeroLevel']] = $norms[$i]['secondLevel'];
				array_push($firstIds, $norms[$i]['id']);
			}
		}
		$firstKeys = array_keys($first);
		$secondKeys = array_keys($second);
		// dd($first, $second);

		return view('super.norm.third', compact('firstIds', 'firstKeys', 'first', 'secondKeys', 'second'));
	}

	/**
	 * 修改一级规范，二级以下需要依靠一级
	 */
	public function postFirstNorm(Request $request)
	{	
		$superId = \Auth::user()->id;
		$tabVal = $request->get('tab_val');
		// 零级规范间以空格分割
		$tabArr = explode(' ', $tabVal);
		
		// 存储所有现有的标注规范
		$norms = Norm::where('superId', '=', $superId)
				->get();
		
		// 删除超级管理员所有的标注规范
		Norm::where('superId', '=', $superId)
				->delete();		
		// dd($norms);

		// 对于每个面板对应的一级标注规范
		for ($i=0; $i<count($tabArr); $i++) 
		{
			// 形如文本标注XXXXX1
			$tempArr = explode('XXXXX', $tabArr[$i]);
			// 形如预处理，预处理2
			$tempArrArr = explode(',', $tempArr[0]);
			
			// 如果规范为空，规范表里直接插入一条数据
			if (count($norms) == 0) 
			{
				for ($k=0; $k<count($tempArrArr); $k++)
				{
					Norm::create(
		    			array_merge(
		        			['flashId'     => $tempArr[1]],
		        			['superId'     => $superId],
		        			['zeroLevel'   => $tempArrArr[$k]],
		        			['firstLevel'  => ''], 
		        			['secondLevel' => ''] 
		    			));	
				}
			}
			// 如果不为空，
			// 先在已有的规范里找到符合条件的规范，原样插入，
			// 然后单独插入
			else 
			{
				for ($k=0; $k<count($tempArrArr); $k++)
				{
					$equal = 0;
					for ($j=0; $j<count($norms); $j++) 
					{
						if ($tempArr[1]==$norms[$j]['flashId'] 
							&& $tempArrArr[$k]==$norms[$j]['zeroLevel'])
						{
							$equal = 1;
							Norm::create(
			        			array_merge(
			            			['flashId'     => $tempArr[1]],
			            			['superId'     => $superId],
			            			['zeroLevel'   => $norms[$j]['zeroLevel']],
			            			['firstLevel'  => $norms[$j]['firstLevel']], 
			            			['secondLevel' => $norms[$j]['secondLevel']]
			        			));
						}
					}
					// 如果在之前的规范中没有符合条件的，单独插入
					if ($equal == 0)
					{
						Norm::create(
	        			array_merge(
	            			['flashId'     => $tempArr[1]],
	            			['superId'     => $superId],
	            			['zeroLevel'   => $tempArrArr[$k]],
	            			['firstLevel'  => ''], 
        					['secondLevel' => '']	
	        			));	
					}
				}
			}
		}
	}

	/**
	 * 修改二级规范，三级以下需要依靠二级
	 */
	public function postSecondNorm(Request $request)
	{	
		$superId = \Auth::user()->id;
		$tabVal = $request->get('tab_val');
		// 零级规范间以空格分割
		$tabArr = explode(' ', $tabVal);
		// 找到需要更改的规范进行更新
		$norms = Norm::where('superId', '=', $superId)
				->get();

		// 删除超级管理员所有的标注规范
		Norm::where('superId', '=', $superId)
				->delete();		
		// dd($tabArr);

		// 对于每个面板对应的一级标注规范
		for ($i=0; $i<count($tabArr); $i++) 
		{
			// 形如句,字XXXXX1XXXXX文本标注
			$tempArr = explode('XXXXX', $tabArr[$i]);
			$tempArrArr = explode(',', $tempArr[0]);
			
			for ($k=0; $k<count($tempArrArr); $k++)
			{
				// 如果规范为空，规范表里直接插入一条数据
				if (count($norms) == 0) 
				{
					Norm::create(
		    			array_merge(
		        			['flashId'     => $tempArr[1]],
		        			['superId'     => $superId],
		        			['zeroLevel'   => $tempArr[2]],
		        			['firstLevel'  => $tempArrArr[$k]], 
		        			['secondLevel' => ''] 
		    			));	
				}
				// 如果不为空，
				// 先在已有的规范里找到符合条件的规范，原样插入，
				// 然后单独插入
				else 
				{
					$equal = 0;
					for ($j=0; $j<count($norms); $j++) 
					{
						// flashId相同、zeroLevel相同、firstLevel相同，才是真正相同
						if ($tempArr[1]==$norms[$j]['flashId'] 
							&& $tempArr[2]==$norms[$j]['zeroLevel']
							&& $tempArr[0]==$norms[$j]['firstLevel'])
						{
							$equal = 1;
							Norm::create(
			        			array_merge(
			            			['flashId'     => $tempArr[1]],
			            			['superId'     => $superId],
			            			['zeroLevel'   => $norms[$j]['zeroLevel']],
			            			['firstLevel'  => $norms[$j]['firstLevel']], 
			            			['secondLevel' => $norms[$j]['secondLevel']]
			        			));
						} 
					}
					// 如果在之前的规范中没有符合条件的，单独插入
					if ($equal == 0)
					{
						Norm::create(
	        			array_merge(
	            			['flashId'     => $tempArr[1]],
	            			['superId'     => $superId],
	            			['zeroLevel'   => $tempArr[2]],
	            			['firstLevel'  => $tempArrArr[$k]], 
	    					['secondLevel' => '']	
	        			));	
					}
				}
			}
		}
	}

	/**
	 * 修改具体名称
	 */
	public function postThirdNorm(Request $request)
	{
		$superId = \Auth::user()->id;
		$tabVal = $request->get('tab_val');
		// 零级规范间以“。”分割
		$tabArr = explode('。', $tabVal);
		
		$tabArr2 = array();
		for ($i=0; $i<count($tabArr); $i++)
		{
			$tabArr3 = explode('.', trim($tabArr[$i], ','));
			for ($j=0; $j<count($tabArr3); $j++)
			{
				array_push($tabArr2, trim($tabArr3[$j], ','));
			}
		}
		// dd($tabArr2);
		// 更新数据库中具体规范的值
		$norms = Norm::where('superId', '=', $superId)->get();
		for ($i=0; $i<count($tabArr2); $i++) 
		{
			$norms[$i]->secondLevel = $tabArr2[$i]=='NULL'?'':$tabArr2[$i];
			$norms[$i]->save();
		}

		$norms = Norm::where('superId', '=', $superId)->get();

		$fileName = "flash/assets/xml/label_types_" . $superId . ".xml";
	    $handle = fopen($fileName, "w");
	    $str = '<?xml version="1.0" encoding="utf-8"?><Types>';
	    $countState=1;

	    $flashIds = array();
	    $first = array();
	    $second = array();
	    for ($i=0; $i<count($norms); $i++)
	    {
	    	// 拼接二级字符串
	    	if (array_key_exists($norms[$i]['zeroLevel'], $first))
	    	{
	    		$first[$norms[$i]['zeroLevel']] = $first[$norms[$i]['zeroLevel']] 
	    										. ',' 
	    										. $norms[$i]['firstLevel'];								

	    		$second[$norms[$i]['zeroLevel']] = $second[$norms[$i]['zeroLevel']] 
	    											. '.' 
	    											. $norms[$i]['secondLevel'];
	    	}
	    	else 
	    	{
	    		$first[$norms[$i]['zeroLevel']] = $norms[$i]['firstLevel'];
	    		$second[$norms[$i]['zeroLevel']] = $norms[$i]['secondLevel'];
	    		array_push($flashIds, $norms[$i]['flashId']);
	    	}
	    }

	    $firstKeys = array_keys($first);
	    $secondKeys = array_keys($second);
	    // dd($first, $second);

	    for ($i=0; $i<count($firstKeys); $i++) 
	    {
	        $Tags1 = explode(",", $first[$firstKeys[$i]]);
	        $Tags2 = explode('.', $second[$secondKeys[$i]]);

	        // dd($Tags1, $Tags2);

	        $flash = Flash::where('id', '=', $flashIds[$i])->first();
	        // dd($flash);
	        $str .= '<Layer1 layerID="'
	        	 . $countState
	        	 . '" label="'
	        	 . $firstKeys[$i]
	        	 . '" classid="'
	        	 . $flash['classId']
	        	 . '" gf="'
	        	 . $flash['hasNorm']
	        	 . '">';

	        for ($j=0; $j<count($Tags1); $j++)
	        {
	            $str .= '<Layer2 layerID="'
	            	 . ($countState + $j + 1)
	            	 . '" label="'
	            	 . $Tags1[$j]
	            	 . '">';

	            for ($k=0; $k<count($Tags2); $k++)
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
