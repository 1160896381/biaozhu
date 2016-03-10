<?php

/**
 * 返回可读性更好的文件尺寸
 */
function human_filesize($bytes, $decimals = 2)
{
    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .@$size[$factor];
}

/**
 * 判断文件的MIME类型是否为图片
 */
function is_image($mimeType)
{
    return starts_with($mimeType, 'image/');
}

/**
 * 判断文件的MIME类型是否为文本
 */
function is_text($mimeType)
{
    return starts_with($mimeType, 'text/');
}

/**
 * 返回上传文件名
 */
function ReturnDoTranFilename()
{
	$filename=md5(uniqid(microtime()));
	return $filename;
}

/**
 * 取得文件扩展名
 */
function GetFiletype($filename)
{
	$filer=explode(".",$filename);
	$count=count($filer)-1;
	return strtolower(".".RepGetFiletype($filer[$count]));
}

function RepGetFiletype($filetype)
{
	$filetype=str_replace('|','_',$filetype);
	$filetype=str_replace(',','_',$filetype);
	$filetype=str_replace('.','_',$filetype);
	return $filetype;
}

/**
 * 获得当前状态
 */
function GetClaimtype($claim)
{	
	$ret = '未分配';
	switch ($claim) {
		case 1:
			$ret = '<font color="red">认领中</font>';
			break;
		case 2:
			$ret = '<font color="orange">已认领</font>';
			break;
		case 3:
			$ret = '<font color="blue">校对中</font>';
			break;
		case 4:
			$ret = '<font color="green">已完成</font>';
			break;
		case 5:
			$ret = '<font color="red">未分配</font>';
			break;
		case 6:
			$ret = '<font color="blue">工作中</font>';
			break;
		case 7:
			$ret = '<font color="orange">已提交</font>';
			break;
		case 8:
			$ret = '<font color="black">已过期</font>';
			break;
		default:
			$ret = '<font color="red">未分配</font>';
			break;
	}

	return $ret;
}

/**
 * 获得类型
 */
function GetClasstype($classId)
{
	switch ($classId) {
		case '1':
			$ret = '文本';
			break;
		case '2':
			$ret = '图片';
			break;
		case '1':
			$ret = '音频';
			break;
		case '2':
			$ret = '视频';
			break;
		default:
			$ret = '文本';
			break;
	}

	return $ret;
}

/**
 * 获得Has类型
 */
function GetHastype($has)
{
	switch ($has) {
		case '1':
			$ret = '需要';
			break;
		case '0':
			$ret = '不需要';
			break;
		default:
			$ret = '不需要';
			break;
	}

	return $ret;
}

/**
 * 取得随机数
 */
function MakePassword($pw_length)
{
	$low_ascii_bound=50;
	$upper_ascii_bound=122;
	$notuse = array(58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
	
	$i = 0;
	$password1 = '';
	while ($i < $pw_length)
	{
		mt_srand((double)microtime()*1000000);
		$randnum = mt_rand($low_ascii_bound, $upper_ascii_bound);
		if (!in_array($randnum,$notuse))
		{
			$password1 = $password1.chr($randnum);
			$i++;
		}
	}	
	return $password1;
}

/**
 * 生成密码，MD5
 */
function GeneratePassword($password, $salt) 
{
	$pw = md5(md5($password).$salt);
	return $pw;
}

/**
* 功能：对utf8进行分词，得到数组
* @param：字符串
* @return：数组
*/
function StringToArray($tag3)
{
	$cind = 0;
	$arr = array();
	for ($i=0; $i < strlen($tag3); $i++) 
	{
	    if (strlen(substr($tag3, $cind, 1)) > 0) 
	    {
	        if (ord(substr($tag3, $cind, 1)) < 192) 
	        {
	            if (substr($tag3, $cind, 1) != " ") 
	            {
	                array_push($arr, substr($tag3, $cind, 1));
	            }
	            $cind++;
	        } 
	        else if (ord(substr($tag3, $cind, 1)) < 224) 
	        {
	            array_push($arr, substr($tag3, $cind, 2));
	            $cind+=2;
	        } 
	        else 
	        {
	            array_push($arr, substr($tag3, $cind, 3));
	            $cind+=3;
	        }
	    }
	}
	return $arr;
}

/**
 * @param: 待分层的字符串
 * @return: 要存储到xml的分好层的字符串
 */
function BuildLayer($tag3)
{
	$arr = array();
    $arr = StringToArray($tag3);
	// 定位最后有几个连续的』，$rear存放个数
	$rear = 0;
	for ($i=count($arr)-1; $i>=0; $i--)
	{
		if ($arr[$i] == '』')
		{
			$rear++;
		}
		else 
		{
			break;
		}
	}
	// 用于存放特殊符号
	$deli = array();
	for ($i=0; $i<count($arr); $i++)
    {
        if ($arr[$i]=='『' || $arr[$i]=='』' || $arr[$i]=='；')
        {
            array_push($deli, $arr[$i]);
        }
    }

    // 将特殊符号进行替换
    $tag3 = str_replace("『", "<>", $tag3);
    $tag3 = str_replace("』", "<>", $tag3);
    $tag3 = str_replace("；", "<>", $tag3);
    // 将$str依据"<>"进行分词
    $newarr = explode("<>", $tag3);

    // 重新插入特殊符号
	if (!empty($deli)) 
	{
	    for ($i=0; $i<count($deli); $i++)
	    {
        	array_splice($newarr, 2*$i+1, 0, $deli[$i]);
	    }
	}

	// 存放层数的数组
	$cs = array();
    // 将起始层设为3
	$lc = 3;
	array_push($cs, 3);
	array_push($cs, $newarr[0]);
    // 遍历数组
    for ($i=1; $i<count($newarr)-2; $i++)
    {
    	if ($newarr[$i] == '『') {
    		// 遇到'『'，将紧挨的下一个数组元素降到下一层
    		$lc++;
    		array_push($cs, $lc);
    		array_push($cs, $newarr[$i+1]);
			// 下一个$newarr元素就不需要遍历了
			$i++;
    	} else if ($newarr[$i] == '；') {
    		array_push($cs, $lc);
    		array_push($cs, $newarr[$i+1]);
			// 下一个$newarr元素就不需要遍历了
			$i++;
    	} else if ($newarr[$i] == '』') {
    		// 遇到'』'，分两种情况
    		if ($newarr[$i+1] == '』') {
    			// 如果下一个元素仍然是'』'，升到上两层
    			$lc=$lc-2;
    			array_push($cs, $lc);
    			array_push($cs, $newarr[$i+2]);
    			$i=$i+2;
    		} else if ($newarr[$i+1] != '』') {
    			// 如果下一个元素不是'』'，升到上一层
    			$lc--;
    			if ($newarr[$i+1] != '')
    			{
	    			array_push($cs, $lc);
	    			array_push($cs, $newarr[$i+1]);
    			}
    			$i++;
    		}
    	}
    }
    $str = '';
    // 3/错字/4/错字1/5/错字11/6/错字111/6/错字112/5/错字12/4/错字2/3/别字/4/别字1/5/别字11/5/别字12/4/别字2
    // 3/错字
    if (count($cs) == 2)
    {
    	$str .= '<Layer3 label="'.$cs[1].'"/>
	';
    }
    else
    {
	    for ($i=0; $i<=count($cs)-3; $i=$i+2)  // 留出最后一位
	    {
	    	if (!empty($cs[$i+1]))
	    	{
		    	if ($cs[$i] == $cs[$i+2])
		    	{
		    		$str .= '<Layer'.$cs[$i].' label="'.$cs[$i+1].'"/>
		';
		    	}
		    	else if ($cs[$i] > $cs[$i+2]) // 依据层数差异来算出闭标签重复几次
		    	{
		    		// $diff是两层之间的差值
		    		$diff = $cs[$i] - $cs[$i+2];
		    		$closeStr = '';
		    		for ($j=0; $j<$diff; $j++)
		    		{
		    			// 通过$j的变化来控制显示的层数
		    			$closeStr .= '</Layer'.($cs[$i]-1-$j).'>';
		    		}
		  			$str .= '<Layer'.$cs[$i].' label="'.$cs[$i+1].'"/>'.$closeStr.'
		';  		
		    	}
		    	else
		    	{
		  			$str .= '<Layer'.$cs[$i].' label="'.$cs[$i+1].'">
		';  		
		    	}	
	    	}
	    	else if ($cs[$i] != 0)
	    	{
	    		$str .= '</Layer'.($cs[$i]-1).'>';
	    	}
	    	
	    }
	    // 处理边界情况
        $rearStr = '';
	    for ($i=$rear; $i>0; $i--)
	    {
	    	$rearStr .= '</Layer'.($i+2).'>';
	    }

    	$str .= '<Layer'.$cs[count($cs)-2].' label="'.$cs[count($cs)-1].'"/>'.$rearStr.'
    	';
    }
    // for test
    // $str .= implode(' ', $rearArr);
    return $str;
}