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
}