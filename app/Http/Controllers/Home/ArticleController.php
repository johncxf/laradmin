<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Stores\Home\ArticleStore;

class ArticleController extends Controller
{
    protected $objStoreArticle;
    public function __construct()
    {
        $this->objStoreArticle = new ArticleStore();
    }

    /**
     * 文章详情页
     * @param $aid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($aid)
    {
        $article = $this->objStoreArticle->getArticleById($aid,auth()->id());
        $uid = 0;
        if (auth()->id()) {
            $uid = auth()->id();
        }
        $this->objStoreArticle->readLog($aid, $uid);
        $comments = $this->objStoreArticle->getComment($aid);
        return view('home.article', compact('article','comments'));
    }

    /**
     * 收藏
     * @param $aid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function star($aid)
    {
        if (!$aid) {
            return back()->with('danger','参数传递错误');
        }
        if ($this->objStoreArticle->is_star($aid,auth()->id())) {// 已收藏
            if ($this->objStoreArticle->unlike($aid,auth()->id())) {
                return back()->with('success','取消收藏成功');
            } else {
                return back()->with('danger','取消收藏失败');
            }
        } else {// 未收藏
            if ($this->objStoreArticle->like($aid,auth()->id())) {
                return back()->with('success','收藏成功');
            } else {
                return back()->with('danger','收藏失败');
            }
        }
    }

    /**
     * 点赞
     * @param $aid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function praise($aid)
    {
        if (!$aid) {
            return back()->with('danger','参数传递错误');
        }
        if ($this->objStoreArticle->is_praise($aid,auth()->id())) {// 已收藏
            if ($this->objStoreArticle->unPraise($aid,auth()->id())) {
                return back()->with('success','取消点赞成功');
            } else {
                return back()->with('danger','取消点赞失败');
            }
        } else {// 未收藏
            if ($this->objStoreArticle->praise($aid,auth()->id())) {
                return back()->with('success','点赞成功');
            } else {
                return back()->with('danger','点赞失败');
            }
        }
    }

}
