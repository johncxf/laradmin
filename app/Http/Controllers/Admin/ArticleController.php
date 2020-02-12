<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Stores\Admin\ArticleStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * @var ArticleStore 文章操作类
     */
    protected $objStoreArticle;

    public function __construct()
    {
        $this->objStoreArticle = new ArticleStore();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = array();
        if ($request['title'] && $request['title'] !== null) {
            $where[] = ['title', 'like', '%'.$request['title'].'%'];
        }
        if ($request['author'] && $request['author'] !== null) {
            $where[] = ['author', 'like', '%'.$request['author'].'%'];
        }
        if ($request['status'] && $request['status'] !== null && in_array($request['status'], [1,2])) {
            $where[] = ['status', '=', $request['status']];
        }

        $articles = $this->objStoreArticle->getAllArticles($where);

        return view('admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $categories = $category->getAll();
        $items = $this->objStoreArticle->getCheckItems();
        $tags = $this->objStoreArticle->getAllTags();
        return view('admin.article.create', compact('categories', 'items', 'tags'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ],[
            'title.required' => '请输入文章内容',
            'content.required' => '请输入文章内容'
        ]);
        $data_article = [
            'title' => $request['title'],
            'content' => $request['content'],
            'uid' => auth('admin')->id(),
            'cid' => 0,
            'thumb' => '',
            'is_top' => 0,
            'remark' => '',
            'status' => 1,
            'create_at' => date('Y-m-d H:i:s',time()),
            'update_at' => date('Y-m-d H:i:s',time()),
        ];
        if ($request['cid']) {
            $data_article['cid'] = $request['cid'];
        }
        if ($request['thumb']) {
            $data_article['thumb'] = $request['thumb'];
        }
        if ($request['is_top']) {
            $data_article['is_top'] = $request['is_top'];
        }
        if ($request['remark']) {
            $data_article['remark'] = $request['remark'];
        }
        if ($request['author']) {
            $data_article['author'] = $request['author'];
        }
        if ($request['status']) {
            $data_article['status'] = $request['status'];
        }
        $item_ids = [];
        $tag_ids = [];
        if ($request['item_id']) {
            $item_ids = $request['item_id'];
        }
        if ($request['tag_id']) {
            $tag_ids = $request['tag_id'];
        }
        $ret = $this->objStoreArticle->createArticle($data_article,$item_ids,$tag_ids);
        if ($request['status'] == 2) {
            if ($ret) {
                return redirect('/admin/article')->with('success', '发布文章成功');
            } else {
                return back()->with('danger', '发布文章失败');
            }
        } else {
            if ($ret) {
                return redirect('/admin/article/'.$ret.'/edit')->with('success', '保存文章成功');
            } else {
                return back()->with('danger', '保存文章失败');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Article $article)
    {
        $categories = $category->getAll();
        $items = $this->objStoreArticle->getCheckItems($article['id']);
        $tags = $this->objStoreArticle->getAllTags();
        $tagIds = $this->objStoreArticle->articleTagIds($article['id']);
        return view('admin.article.edit', compact('article','categories', 'items', 'tags','tagIds'));
    }

    /**
     * 编辑文章
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ],[
            'title.required' => '请输入文章内容',
            'content.required' => '请输入文章内容'
        ]);
        $data_article = [
            'title' => $request['title'],
            'content' => $request['content'],
            'update_at' => date('Y-m-d H:i:s',time()),
        ];
        if ($request['cid']) {
            $data_article['cid'] = $request['cid'];
        }
        if ($request['thumb']) {
            $data_article['thumb'] = $request['thumb'];
        }
        if ($request['is_top']) {
            $data_article['is_top'] = $request['is_top'];
        }
        if ($request['remark']) {
            $data_article['remark'] = $request['remark'];
        }
        if ($request['author']) {
            $data_article['author'] = $request['author'];
        }
        $item_ids = [];
        $tag_ids = [];
        if ($request['item_id']) {
            $item_ids = $request['item_id'];
        }
        if ($request['tag_id']) {
            $tag_ids = $request['tag_id'];
        }
        if ($request['status']) {
            $data_article['status'] = $request['status'];

        }
        if ($this->objStoreArticle->createArticle($data_article,$item_ids,$tag_ids,$id)) {
            return back()->with('success', '修改文章成功');
        } else {
            return back()->with('danger', '修改文章失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->objStoreArticle->deleteArticle($id)) {
            return redirect('/admin/article')->with('success', '删除文章成功');
        } else {
            return back()->with('danger', '删除文章失败');
        }
    }

    /**
     * @param $aid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function issue($aid)
    {
        $article = $this->objStoreArticle->getArticleById($aid);
        if ($article->status == 1) {
            $status = 2;
            $msg = '文章发表';
        } else {
            $status = 1;
            $msg = '撤销发布';
        }
        if ($this->objStoreArticle->changeStatus($aid, $status)) {
            return back()->with('success', $msg.'成功');
        } else {
            return back()->with('warning', $msg.'失败');
        }
    }
}
