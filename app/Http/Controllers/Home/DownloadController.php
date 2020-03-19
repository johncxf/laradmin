<?php

namespace App\Http\Controllers\Home;

use App\Stores\Home\DownloadStore;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    /**
     * @var DownloadStore
     */
    protected $objStoreDownload;

    /**
     * DownloadController constructor.
     */
    public function __construct()
    {
        $this->objStoreDownload = new DownloadStore();
    }

    /**
     * 下载资源首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $resources = $this->objStoreDownload->getAllResources(5);
        return view('home.download.index',compact('resources'));
    }

    /**
     * 下载详情页
     * @param $rid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($rid)
    {
        $resource = $this->objStoreDownload->getResourceInfo($rid,auth()->id());
        $resources = $this->objStoreDownload->recommend($rid);
        return view('home.download.detail',compact('resource','resources'));
    }

    /**
     * 收藏
     * @param $rid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function star($rid)
    {
        if (!$rid) {
            return back()->with('danger','参数传递错误');
        }
        if ($this->objStoreDownload->is_star($rid,auth()->id())) {// 已收藏
            if ($this->objStoreDownload->unlike($rid,auth()->id())) {
                return back()->with('success','取消收藏成功');
            } else {
                return back()->with('danger','取消收藏失败');
            }
        } else {// 未收藏
            if ($this->objStoreDownload->like($rid,auth()->id())) {
                return back()->with('success','收藏成功');
            } else {
                return back()->with('danger','收藏失败');
            }
        }
    }

    /**
     * 下载资源
     * @param $rid
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function make($rid)
    {
        $resource = $this->objStoreDownload->getResource($rid);
        if (!$resource) {
            return back()->with('danger','该文件不存在');
        }
        $account = $this->objStoreDownload->getAccountInfo(auth()->id());
        if ($account['gold'] < $resource['gold']) {
            return back()->with('danger','积分不够');
        }
        if ($this->objStoreDownload->downloadLog(auth()->id(),$resource)) {
            return response()->download($resource['content'],$resource['title'].'.'.$resource['ext']);
        } else {
            return back()->with('danger','下载失败');
        }
    }
}
