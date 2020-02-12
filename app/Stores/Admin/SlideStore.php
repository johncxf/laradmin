<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/10
 * @Time: 16:33
 */

namespace App\Stores\Admin;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class SlideStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $content
     * @return array
     */
    public function saveImg($content)
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
            $filename = time().'.'.$ext;
            //文件存储目录
            $dir = 'uploads/admin/slide/'.date('Y-m-d');
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

    /**
     * @param $data
     * @return int
     */
    public function addSlide($data)
    {
        return DB::connection($this->CONN_DB)->table($this->SLIDE_TB)->insertGetId($data);
    }

    /**
     * @param $data
     * @param $sid
     * @return bool
     */
    public function updateSlide($data,$sid)
    {
        if (!$sid || empty($data)) {
            return false;
        }
        try {
            DB::connection($this->CONN_DB)->table($this->SLIDE_TB)
                ->where('id',$sid)
                ->update($data);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @param $sid
     * @return mixed
     */
    public function getUrl($sid)
    {
        return DB::connection($this->CONN_DB)->table($this->SLIDE_TB)->where('id',$sid)->value('content');
    }

    /**
     * @param $sid
     * @return bool
     */
    public function deleteSlide($sid)
    {
        if (!$sid) {
            return false;
        }
        try {
            DB::connection($this->CONN_DB)->table($this->SLIDE_TB)
                ->where('id',$sid)
                ->delete();
            $url = $this->getUrl($sid);
            if (file_exists($url)) {
                unlink($url);
            }
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}