<?php

namespace App\Http\Controllers\Admin;

use App\Resource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\UploadFileRequest;
use App\Services\UploadsManager;
use Illuminate\Support\Facades\File;


class ResourceController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    public function index()
    {
        $userId = \Auth::user()->id;
        $resources = Resource::where('userId', '=', $userId)->get();
        return view('admin.resource.index', compact('resources'));
    }

    /**
     * 删除文件
     */
    public function deleteFile(Request $request)
    {
        $del_file_name = $request->get('del_file_name');
        $del_file_id = $request->get('del_file_id');
        
        $path = $request->get('folder').'/'.$del_file_name;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            Resource::where('id', '=', $del_file_id)->delete();
            return redirect()
                ->back()
                ->withSuccess("File '$del_file_name' deleted.");
        }

        $error = $result ? : "An error occurred deleting file.";
        return redirect()
                ->back()
                ->withErrors([$error]);
    }

    /**
     * 上传文件
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file_ = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file_['name'];
        $path = str_finish($request->get('folder'), '/') . $fileName;
        $content = File::get($file_['tmp_name']);
        
        // 获得文件详情
        $file = $this->manager->fileDetails($path);

        // 成功标志
        $result = $this->manager->saveFile($path, $content);

        // dd($file);
        if ($result === true) {
            Resource::create(
                array_merge(
                    ['userId'   => \Auth::user()->id],
                    ['mimeType' => $file['mimeType']],
                    ['fileName' => $fileName], 
                    ['fileSize' => $file_['size']],
                    ['webPath'  => $file['webPath']]
                ));
            return redirect()
                    ->back()
                    ->withSuccess("File '$fileName' uploaded.");
        }

        $error = $result ? : "An error occurred uploading file.";
        return redirect()
                ->back()
                ->withErrors([$error]);
    }

    /**
     * 批量上传文件
     */
    public function batchIndex()
    {
        return view('admin.resource.batch');
    }

    public function batchUploadFile(Request $request)
    {
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // Support CORS
        // header("Access-Control-Allow-Origin: *");
        // other CORS headers if any...
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') 
        {
            exit; // finish preflight CORS requests here
        }

        if (!empty($_REQUEST[ 'debug' ])) 
        {
            $random = rand(0, intval($_REQUEST[ 'debug' ]));
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

        $title = $request->get('name');
        $subPath = date("Y-m-d");
        $classId = $request->get('classId');
        $published_at = time();
        $fileSize = $request->get('size');

        $fileType = GetFiletype($title);
        $insertFile = ReturnDoTranFilename();
        $title_u = $insertFile.$fileType;

        $title_raw = preg_replace("/\..*$/", "", $title);

        if ($classId == 1)
        {
            $uploadDir = 'text/'.$subPath;    
            
            $text=file_get_contents($_FILES["file"]["tmp_name"]);    
            $text=mb_convert_encoding($text, 'UTF-8','GBK,UTF-8');
            $tempPath=$_FILES["file"]["tmp_name"];
            file_put_contents($tempPath, $text);
            $upText = '/d/file/'.$uploadDir.'/'.$title_u;
            $init_xml = '<UnitCorpus type="text" title="'.$title_raw.'" content="'.$upText.'"></UnitCorpus>';
            
            // $query="insert into {$dbtbpre}ecms_text(classid,newspath,userid,username,truetime,lastdotime,title,newstime,upload,claim,init_xml) values('$classid','$newspath','$logininid','$loginin','$newstime','$newstime','$title_raw','$newstime','$uptext',5,'$init_xml')";
        }
        elseif ($classId == 2) 
        {
            $uploadDir = 'tupian/'.$subPath;
            $upPic = '/d/file/'.$uploadDir.'/'.$title_u;
            $init_xml = '<UnitCorpus type="picture" title="'.$title_raw.'" content="'.$upPic.'"><Pages><Page><OriginalPictureName>'.$uppic.'</OriginalPictureName><PreProcessedPictureName></PreProcessedPictureName></Page></Pages></UnitCorpus>';
            // $query="insert into {$dbtbpre}ecms_pic(classid,newspath,userid,username,truetime,lastdotime,title,newstime,upload,claim,init_xml) values('$classid','$newspath','$logininid','$loginin','$newstime','$newstime','$title_raw','$newstime','$uppic',5,'$init_xml')";
        }

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
            $fileName = $title_u;
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else 
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

        $filePath = $targetDir . '/' . $fileName;
        $uploadPath = $uploadDir . '/' . $fileName;

        dd($uploadPath);
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
                $tmpfilePath = $targetDir . '/' . $file;

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
    }
}