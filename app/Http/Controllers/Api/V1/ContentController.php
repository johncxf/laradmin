<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Article;
use App\Transformers\ContentTransformer;

class ContentController extends BaseApiController
{
    // 文章列表
    public function index()
    {
        $contents = Article::where('status',2)->orderBy('create_at','desc')->paginate(5);

        return $this->response->paginator($contents, new ContentTransformer());
    }

    // 文章详情
    public function show($id)
    {
        $content = Article::where('status',2)->findOrFail($id);

        return $this->response->array($content->toArray());
    }
    // 置顶文章
    public function top()
    {
        $contents = Article::where('status',2)->where('is_top',1)->orderBy('create_at','desc')->paginate(5);

        return $this->response->paginator($contents, new ContentTransformer());
    }
}
