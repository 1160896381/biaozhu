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
 * 生成密码
 */
function GeneratePassword($password, $salt) 
{
	$pw = md5(md5($password).$salt);
	return $pw;
} 