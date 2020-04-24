<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SlideRequest;
use App\Models\Slide;
use App\Stores\Admin\SlideStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideController extends Controller
{
    protected $objStoreSlide;
    public function __construct()
    {
        $this->objStoreSlide = new SlideStore();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Slide $slide)
    {
        $slides = $slide->getAll();
        return view('admin.slide.index',compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slide.create');
    }

    /**
     * @param SlideRequest $slideRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SlideRequest $slideRequest)
    {
        $ret = $this->objStoreSlide->saveImg($slideRequest['content']);
        if (empty($ret)) {
            return back()->with('danger','上传图片失败');
        }
        $url = $ret['save_path'].'/'.$ret['file_name'];
        $data = [
            'name' => $slideRequest['name'],
            'content' => $url,
            'status' => 1,
            'type' => 'home',
            'sort' => 0,
        ];
        if ($slideRequest['status']) {
            $data['status'] = $slideRequest['status'];
        }
        if ($slideRequest['type']) {
            $data['type'] = $slideRequest['type'];
        }
        if ($slideRequest['sort']) {
            $data['sort'] = $slideRequest['sort'];
        }
        if ($this->objStoreSlide->addSlide($data)) {
            return redirect('/admin/slide')->with('success','添加成功');
        } else {
            if (file_exists($url)) {
                unlink($url);
            }
            return back()->with('danger','添加失败');
        }
    }

    /**
     * @param Slide $slide
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Slide $slide)
    {
        return view('admin.slide.edit',compact('slide'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
           'name' => 'required'
        ]);
        $data = [
            'name' => $request['name']
        ];
        if ($request['status'] !== null) {
            $data['status'] = $request['status'];
        }
        if ($request['type'] !== null) {
            $data['type'] = $request['type'];
        }
        if ($request['sort'] !== null) {
            $data['sort'] = $request['sort'];
        }
        if (!$request['content']) {
            if ($this->objStoreSlide->updateSlide($data,$id)) {
                return back()->with('success','修改成功');
            } else {
                return back()->with('danger','修改失败');
            }
        } else {
            $ret = $this->objStoreSlide->saveImg($request['content']);
            if (empty($ret)) {
                return back()->with('danger','上传图片失败');
            }
            $url = $ret['save_path'].'/'.$ret['file_name'];
            $data['content'] = $url;
            $oldImg = $this->objStoreSlide->getUrl($id);
            if ($this->objStoreSlide->updateSlide($data,$id)) {
                if (file_exists($oldImg)) {
                    unlink($oldImg);
                }
                return redirect('/admin/slide')->with('success','修改成功');
            } else {
                if (file_exists($url)) {
                    unlink($url);
                }
                return back()->with('danger','修改失败');
            }
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
        if ($this->objStoreSlide->deleteSlide($id)) {
            return redirect('/admin/slide')->with('success','删除失败');
        } else {
            return back()->with('danger','删除失败');
        }
    }
}
