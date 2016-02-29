<?php
// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// empire
define('EmpireCMSAdmin','1');
require('../../e/class/connect.php');
require('../../e/class/db_sql.php');
require('../../e/class/functions.php');
require("../../e/data/dbcache/class.php");
$link=db_connect();
$empire=new mysqlquery();
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];

// Support CORS
// header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') 
{
    exit; // finish preflight CORS requests here
}

if ( !empty($_REQUEST[ 'debug' ]) ) 
{
    $random = rand(0, intval($_REQUEST[ 'debug' ]) );
    if ( $random === 0 ) 
    {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
usleep(5000);

// Settings
$leixing = $_POST[leixing];
$title = $_POST[name];
$newspath = date("Y-m-d");
$tb = $class_r[$leixing][tbname];
$classid = $_POST[classid];
$newstime = time();
$filesize = $_POST[size];
// sunli 2014-12-18 这些函数在connect.php中
$filetype=GetFiletype($title);
$insertfile=ReturnDoTranFilename($title,$classid);
$title_u=$insertfile.$filetype;
// $title_u=urlencode($title);
$title_raw=preg_replace("/\..*$/", "", $title);

if ($leixing == 1)
{
    $uploadDir = 'wenben/'.$newspath;    
    // 将文本文件格式转换为utf-8
    // sunli 2014-12-24
    $text=file_get_contents($_FILES["file"]["tmp_name"]);    
    $text=mb_convert_encoding($text, 'UTF-8','GBK,UTF-8');
    $temppath=$_FILES["file"]["tmp_name"];
    file_put_contents($temppath, $text);
    $uptext = '/d/file/'.$uploadDir.'/'.$title_u;
    $init_xml = '<UnitCorpus type="text" title="'.$title_raw.'" content="'.$uptext.'"></UnitCorpus>';
    // 获得当前最大的id数
    // $qid=$empire->fetch1("select max(id) as id from {$dbtbpre}ecms_text");
    // 得到要插入的id
    // $qid=$qid['id']+1;
    $query="insert into {$dbtbpre}ecms_text(classid,newspath,userid,username,truetime,lastdotime,title,newstime,upload,claim,init_xml) values('$classid','$newspath','$logininid','$loginin','$newstime','$newstime','$title_raw','$newstime','$uptext',5,'$init_xml')";
    $query_index="insert into {$dbtbpre}ecms_text_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$classid',1,'$newstime','$newstime','$newstime',1)";
    // $query_data="insert into {$dbtbpre}ecms_text_data_1(classid) values(1) where ";
}
elseif ($leixing == 2) 
{
    $uploadDir = 'tupian/'.$newspath;
    $uppic = '/d/file/'.$uploadDir.'/'.$title_u;
    $init_xml = '<UnitCorpus type="picture" title="'.$title_raw.'" content="'.$uppic.'"><Pages><Page><OriginalPictureName>'.$uppic.'</OriginalPictureName><PreProcessedPictureName></PreProcessedPictureName></Page></Pages></UnitCorpus>';
    // 获得当前最大的id数
    // $qid=$empire->fetch1("select max(id) as id from {$dbtbpre}ecms_pic");
    // 得到要插入的id
    // $qid=$qid['id']+1;
    $query="insert into {$dbtbpre}ecms_pic(classid,newspath,userid,username,truetime,lastdotime,title,newstime,upload,claim,init_xml) values('$classid','$newspath','$logininid','$loginin','$newstime','$newstime','$title_raw','$newstime','$uppic',5,'$init_xml')";
    $query_index="insert into {$dbtbpre}ecms_pic_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$classid',1,'$newstime','$newstime','$newstime',1)";
    // $query_data="insert into {$dbtbpre}ecms_pic_data_1(classid) values(2)";
}
$pubid=ReturnInfoPubid($classid, $qid);
// 获得当前最大的id数
// $fileid=$empire->fetch1("select max(fileid) as fileid from {$dbtbpre}enewsfile_1");
// 得到要插入的id
// $fileid=$fileid['fileid']+1;
$query_file="insert into {$dbtbpre}enewsfile_1(pubid,filename,filesize,path,adduser,filetime,classid,no) values('$pubid','$title_u','$filesize','$newspath','$loginin','$newstime','$leixing','$title')";
$empire->query($query);
$empire->query($query_index);
// $empire->query($
$empire->query($query_file);
//更新栏目信息数
$empire->query("update {$dbtbpre}enewsclass set allinfos=allinfos+1,infos=infos+1 where classid='$classid' limit 1");

$targetDir = 'upload_tmp';
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds

// Create target dir
if (!file_exists($targetDir)) 
{
    @mkdir($targetDir);
}

// Create target dir
if (!file_exists($uploadDir)) 
{
    @mkdir($uploadDir);
}

// Get a file name
if (isset($_REQUEST["name"])) 
{
    // $fileName = $_REQUEST["name"];
    $fileName = $title_u;
} 
elseif (!empty($_FILES)) 
{
    $fileName = $_FILES["file"]["name"];
} 
else 
{
    $fileName = uniqid("file_");
}

$md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$md5File = $md5File ? $md5File : array();

if (isset($_REQUEST["md5"]) && 
    array_search($_REQUEST["md5"], $md5File ) !== FALSE ) 
{
    die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Remove old temp files
if ($cleanupTargetDir) 
{
    if (!is_dir($targetDir) || 
        !$dir = opendir($targetDir)) 
    {
        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
    }

    while (($file = readdir($dir)) !== false) 
    {
        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

        // If temp file is current file proceed to the next
        if ($tmpfilePath == "{$filePath}_{$chunk}.part" || 
            $tmpfilePath == "{$filePath}_{$chunk}.parttmp") 
        {
            continue;
        }

        // Remove temp file if it is older than the max age and is not the current file
        if (preg_match('/\.(part|parttmp)$/', $file) && 
            (@filemtime($tmpfilePath) < time() - $maxFileAge)) 
        {
            @unlink($tmpfilePath);
        }
    }
    closedir($dir);
}


// Open temp file
if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) 
{
    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) 
{
    if ($_FILES["file"]["error"] || 
        !is_uploaded_file($_FILES["file"]["tmp_name"])) 
    {
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    }

    // Read binary input stream and append it to temp file
    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) 
    // if (!$in = @fopen($title_u, "rb")) 
    {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
} 
else 
{
    if (!$in = @fopen("php://input", "rb")) 
    {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
}

while ($buff = fread($in, 4096)) 
{
    fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

$index = 0;
$done = true;
for( $index=0; $index<$chunks; $index++ ) 
{
    if ( !file_exists("{$filePath}_{$index}.part") ) 
    {
        $done = false;
        break;
    }
}
if ( $done ) 
{
    if (!$out = @fopen($uploadPath, "wb")) 
    {
        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    }

    if ( flock($out, LOCK_EX) ) 
    {
        for( $index = 0; $index < $chunks; $index++ ) 
        {
            if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) 
            {
                break;
            }

            while ($buff = fread($in, 4096)) 
            {
                fwrite($out, $buff);
            }

            @fclose($in);
            @unlink("{$filePath}_{$index}.part");
        }

        flock($out, LOCK_UN);
    }
    @fclose($out);
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');