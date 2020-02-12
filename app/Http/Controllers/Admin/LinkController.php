<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LinkRequest;
use App\Models\Link;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Link $link)
    {
        $links = $link->get()->toArray();
        return view('admin.link.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.link.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkRequest $linkRequest, Link $link)
    {
        $link->fill($linkRequest->all());
        if ($link->save()) {
            return redirect('/admin/link')->with('success', '添加成功');
        } else {
            return back()->with('danger', '添加失败');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *edit.blade.php
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        return view('admin.link.edit', compact('link'));
    }

    /**
     * 更新
     * @param LinkRequest $linkRequest
     * @param Link $link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LinkRequest $linkRequest, Link $link)
    {
        if ($link->update($linkRequest->all())) {
            return redirect('/admin/link')->with('success', '编辑成功');
        } else {
            return back()->with('danger', '编辑失败');
        }
    }

    /**
     * 删除
     * @param Link $link
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Link $link)
    {
        if ($link->delete()) {
            return redirect('/admin/link')->with('success', '删除成功');
        } else {
            return back()->with('danger', '删除失败');
        }
    }
}
