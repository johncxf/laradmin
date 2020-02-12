<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    public function make(Request $request)
    {
        $file = $request->file('picture');
        if ($file->isValid()) {
            //获取文件的扩展名
            $ext = $file->getClientOriginalExtension();
            //定义文件名
            $filename = time().$ext;
            //文件存储目录
            $dir = 'uploads/'.date('Y-m-d');
            $file->move($dir, $filename);
            return ['code' => 0, 'data' => url($dir.'/'.$filename), 'msg' => '上传成功'];
        } else {
            return ['code' => 0, 'data' => '', 'msg' => '上传失败'];
        }
    }

    public function compressUpload(Request $request)
    {
        dd($request->all());
    }
}
