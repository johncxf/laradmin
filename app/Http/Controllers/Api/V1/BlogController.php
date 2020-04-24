<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Slide;
use App\Stores\Api\BlogStore;
use Illuminate\Http\Request;

class BlogController extends BaseApiController
{
    protected $objStoreBlog;

    public function __construct()
    {
        parent::__construct();
        $this->objStoreBlog = new BlogStore();
    }

    /**
     * 博客
     * @method GET
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $lists = $this->objStoreBlog->getLists();

        return $this->response->array($lists);
    }

    /**
     * 博客详情
     * @method GET
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $content = $this->objStoreBlog->getContentDetail($id);

        $this->objStoreBlog->read($id);

        return $this->response->array($content);
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function blogBanner(Request $request)
    {
        $host = $request->getSchemeAndHttpHost();
        $limit = \request()->query('limit',3);
        $banners = Slide::where('type','blog')->where('status',1)->orderBy('sort','asc')->limit($limit)->get()->toArray();
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
