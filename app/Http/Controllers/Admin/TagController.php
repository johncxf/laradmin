<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TagRequest;
use App\Models\Item;
use App\Models\Tag;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Tag $tag)
    {
        $tags = $tag->get()->toArray();
        return view('admin.tag', compact('tags'));
    }

    /**
     * 添加标签
     * @param TagRequest $tagRequest
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TagRequest $tagRequest, Tag $tag)
    {
        $tag->fill($tagRequest->all());
        if ($tag->save()) {
            return redirect('/admin/tag')->with('success', '添加成功');
        } else {
            return back()->with('danger', '添加失败');
        }
    }

    /**
     * 编辑标签
     * @param TagRequest $tagRequest
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TagRequest $tagRequest, Tag $tag)
    {
        if ($tag->update($tagRequest->all())) {
            return redirect('/admin/tag')->with('success', '编辑成功');
        } else {
            return back()->with('danger', '编辑失败');
        }

    }

    /**
     * 删除
     * @param Item $item
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        if ($tag->delete()) {
            return redirect('/admin/tag')->with('success', '标签删除成功');
        } else {
            return back()->with('danger', '删除失败');
        }
    }
}
