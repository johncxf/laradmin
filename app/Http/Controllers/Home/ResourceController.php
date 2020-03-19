<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\Home\ResourceRequest;
use App\Models\Item;
use App\Models\Resource;
use App\Stores\Home\ResourceStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    protected $objStoreResource;
    public function __construct()
    {
        $this->objStoreResource = new ResourceStore();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = $this->objStoreResource->getAllResource(auth()->id());
        return view('home.resource.index',compact('resources'));
    }

    /**
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Item $item)
    {
        $items = $item->getAll(null,'resource');
        $tags = $this->objStoreResource->getAllTags();
        return view('home.resource.create',compact('items','tags'));
    }

    /**
     * @param ResourceRequest $resourceRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ResourceRequest $resourceRequest)
    {
        $file = $resourceRequest->file('content');
        if (!$file) {
            return back()->with('danger','请上传文件');
        }
        if ($file->isValid()) {
            // 获取文件大小
            $size = $file->getSize();
            // 最大上传限制5M
            $maxSize = 5 * 1024 * 1024;
            if ($size > $maxSize) {
                return back()->with('danger','上传文件过大');
            }
            //获取文件的扩展名
            $ext = $file->getClientOriginalExtension();
            $exts = config('ext');
            if (!$ext || !array_key_exists(strtolower($ext),$exts)) {
                return back()->with('danger','上传文件格式不支持');
            }
            //定义文件名
            $filename = time().Str::random(5).'.'.$ext;
            //文件存储目录
            $dir = 'uploads/resource/'.date('Y-m-d');
            // 保存文件
            $file->move($dir,$filename);
            //处理数据
            $data = [
                'uid' => auth()->id(),
                'title' => $resourceRequest['title'],
                'content' => $dir.'/'.$filename,
                'ext' => $ext,
                'size' => $size,
                'item_id' => $resourceRequest['item_id'],
                'remark' => $resourceRequest['remark'],
                'status' => $resourceRequest['status'],
                'gold' => $resourceRequest['gold'],
                'create_at' => date('Y-m-d H:i:s',time())
            ];
            $tags = $resourceRequest['tag_id'];
            if ($this->objStoreResource->addResource($data,$tags)) {
                return redirect('/resource')->with('success','上传资源成功');
            } else {
                if (file_exists($dir.'/'.$filename)) {
                    unlink($dir.'/'.$filename);
                }
                return back()->with('danger','上传失败');
            }
        } else {
            return back()->with('danger','文件无效');
        }
    }

    /**
     * @param Item $item
     * @param Resource $resource
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Item $item,Resource $resource)
    {
        $items = $item->getAll(null,'resource');
        $tags = $this->objStoreResource->getAllTags();
        $tag_ids = $this->objStoreResource->getTagIds($resource['id']);
        return view('home.resource.edit',compact('items','tags','resource','tag_ids'));
    }

    /**
     * @param ResourceRequest $resourceRequest
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ResourceRequest $resourceRequest, $id)
    {
        $data = [];
        $tag_ids = [];
        if (isset($resourceRequest['title']) && $resourceRequest['title']) {
            $data['title'] = $resourceRequest['title'];
        }
        if (isset($resourceRequest['type']) && $resourceRequest['type']) {
            $data['type'] = $resourceRequest['type'];
        }
        if (isset($resourceRequest['item_id']) && $resourceRequest['item_id']) {
            $data['item_id'] = $resourceRequest['item_id'];
        }
        if (isset($resourceRequest['status']) && $resourceRequest['status']) {
            $data['status'] = $resourceRequest['status'];
        }
        if (isset($resourceRequest['gold']) && $resourceRequest['gold']) {
            $data['gold'] = $resourceRequest['gold'];
        }
        if (isset($resourceRequest['remark']) && $resourceRequest['remark']) {
            $data['remark'] = $resourceRequest['remark'];
        }
        if (isset($resourceRequest['tag_id']) && $resourceRequest['tag_id']) {
            $tag_ids = $resourceRequest['tag_id'];
        }
        if ($this->objStoreResource->updateResource($data,$id,auth()->id(),$tag_ids)) {
            return redirect('/resource')->with('success','修改成功');
        } else {
            return back()->with('danger','修改失败');
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
        if ($this->objStoreResource->deleteResource($id,auth()->id())) {
            return back()->with('success','删除成功');
        } else {
            return back()->with('danger','删除失败');
        }
    }
}
