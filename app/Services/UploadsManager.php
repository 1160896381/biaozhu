<?php

namespace App\Services;

use Carbon\Carbon;
use Dflydev\ApacheMimeTypes\PhpRepository;
use Illuminate\Support\Facades\Storage;

class UploadsManager
{
    protected $disk;
    protected $mimeDetect;

    public function __construct(PhpRepository $mimeDetect)
    {
        $this->disk = Storage::disk(config('resource.uploads.storage'));
        $this->mimeDetect = $mimeDetect;
    }

    /**
     * 返回文件详细信息数组
     */
    public function fileDetails($path)
    { 
        $path = '/' . ltrim($path, '/');
        
        return [
            'fullPath' => $path,
            'webPath' => $this->fileWebpath($path),
            'mimeType' => $this->fileMimeType($path)
        ];
    }

    /**
     * 返回文件完整的web路径
     */
    public function fileWebpath($path)
    { 
        $path = rtrim(config('resource.uploads.webpath'), '/') . '/' .ltrim($path, '/');        
        return url($path);
    }

    /**
     * 返回文件MIME类型
     */
    public function fileMimeType($path)
    {
        return $this->mimeDetect->findType(
            pathinfo($path, PATHINFO_EXTENSION)
        );
    }

    /**
     * 删除文件
     */
    public function deleteFile($path)
    {
        if (! $this->disk->exists($path)) {
            return "File does not exist.";
        }

        return $this->disk->delete($path);
    }

    /**
     * 保存文件
     */
    public function saveFile($path, $content)
    {
        // if ($this->disk->exists($path)) {
        //     return "File already exists.";
        // }

        return $this->disk->put($path, $content);
    }
}