<?php

namespace App\Http\Controllers\Home;

use App\Stores\Home\ArticleStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    protected $objStoreArticle;
    public function __construct()
    {
        $this->objStoreArticle = new ArticleStore();
    }
    /**
     * 评论文章
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'article_id' => 'required|integer',
            'content' => 'required|between:1,128'
        ],[
            'article_id.required' => '参数传递错误',
            'article_id.integer' => '参数传递错误',
            'content.required' => '评论内容不能为空',
            'content.between:1,128' => '评论内容不能超过128字',
        ]);
        $data = [
            'article_id' => $request['article_id'],
            'uid' => auth()->id(),
            'pid' => 0,
            'target_id' => 0,
            'content' => $request['content'],
            'status' => 1,
            'create_at' => date('Y-m-d H:i:s',time())
        ];
        if ($this->objStoreArticle->reply($data)) {
            return back()->with('success', '评论成功');
        } else {
            return back()->with('danger', '评论失败');
        }
    }

    /**
     * 回复评论
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reply(Request $request)
    {
        $this->validate($request,[
            'article_id' => 'required|integer',
            'pid' => 'required|integer',
            'target_id' => 'required|integer',
            'content' => 'required|between:1,128'
        ],[
            'article_id.required' => '参数传递错误',
            'article_id.integer' => '参数传递错误',
            'pid.required' => '参数传递错误',
            'pid.integer' => '参数传递错误',
            'target_id.required' => '参数传递错误',
            'target_id.integer' => '参数传递错误',
            'content.required' => '评论内容不能为空',
            'content.between:1,128' => '评论内容不能超过128字',
        ]);
        $data = [
            'article_id' => $request['article_id'],
            'uid' => auth()->id(),
            'pid' => $request['pid'],
            'target_id' => $request['target_id'],
            'content' => $request['content'],
            'status' => 1,
            'create_at' => date('Y-m-d H:i:s',time())
        ];
        if ($this->objStoreArticle->reply($data)) {
            return back()->with('success', '评论成功');
        } else {
            return back()->with('danger', '评论失败');
        }
    }
}
