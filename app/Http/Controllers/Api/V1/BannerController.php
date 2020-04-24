<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Slide;
use Illuminate\Http\Request;

class BannerController extends BaseApiController
{
    // 幻灯片
    public function index(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $limit = \request()->query('limit',3);
        $banners = Slide::where('type','miniprogram')->where('status',1)->orderBy('sort','asc')->limit($limit)->get()->toArray();
        $data = [];
        foreach ($banners as $key => $banner) {
            $data[] = [
                'name' => $banner['name'],
                'content' => $host.'/'.$banner['content']
            ];
        }
        return $this->response->array($data);
    }

}
