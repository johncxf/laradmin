<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ItemRequest;
use App\Models\Item;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Item $item)
    {
        $items = $item->getAll();
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Item $item)
    {
        $items = $item->getAll();
        return view('admin.item.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $itemRequest, Item $item)
    {
        $item->fill($itemRequest->all());
        if ($item->save()) {
            return redirect('/admin/item')->with('success', '添加成功');
        } else {
            return back()->with('danger', '添加失败');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $items = $item->getAll($item);
        return view('admin.item.edit', compact('items', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $itemRequest, Item $item)
    {
        if ($item->update($itemRequest->all())) {
            return redirect('/admin/item')->with('success', '编辑成功');
        } else {
            return back()->with('danger', '编辑失败');
        }
    }

    /**
     * @param Item $item
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Item $item)
    {
        if ($item->hasChild()) {
            return back()->with('danger', '请先删除该分类下的子分类');
        }
        if ($item->delete()) {
            return redirect('/admin/item')->with('success', '分类删除成功');
        } else {
            return back()->with('danger', '删除失败');
        }
    }

}
