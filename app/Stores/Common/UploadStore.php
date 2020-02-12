<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/11
 * @Time: 20:13
 */

namespace App\Stores\Common;


use App\Stores\BaseStore;
use Illuminate\Support\Str;

class UploadStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    public function putImg($content,$rootPath='uploads/public/')
    {
        //处理接受到的content内容
        list($type, $imagedata) = explode(';', $content);
        list(, $imagedata)      = explode(',', $imagedata);
        $base64 = base64_decode($imagedata);
        list(,$ext) = explode('/', $type);
        $ext = strtolower($ext);
        if(!in_array($ext, array('jpg', 'jpeg', 'png'))) {
            return [];
        }
        $picture[] = array('ext' => $ext, 'base64' => $base64);
        if ($picture) {
            //定义文件名
            $filename = time().Str::random(5).'.'.$ext;
            //文件存储目录
            $dir = $rootPath.date('Y-m-d');
            // 生成图片
            if(!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            //生成图片
            file_put_contents($dir.'/'.$filename, $picture[0]['base64']);
            return [
                'file_name' => $filename,
                'save_path' => $dir,
            ];
        } else {
            return [];
        }
    }
}