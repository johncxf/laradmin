<?php

namespace App\Http\Controllers\Admin;

use App\Stores\Admin\ConfigStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    protected $objStoreConfig;
    /**
     * SiteController constructor.
     */
    public function __construct()
    {
        $this->objStoreConfig = new ConfigStore();
    }

    //系统配置页
    public function index()
    {
        $siteName = $this->objStoreConfig->getConfigByName('name');
        $beiAn =$this->objStoreConfig->getConfigByName('beian');
        return view('admin.site.index', compact('siteName', 'beiAn'));
    }
    //系统配置
    public function set(Request $request)
    {
        $data = $this->validate(($request), [
            'sitename' => 'nullable|between:2,10',
            'beian' => 'nullable|between:2,255',
        ]);
        if ($data['sitename']) {
            $this->objStoreConfig->updateConfigByName('name', $data['sitename']);
        }
        if ($data['beian']) {
            $this->objStoreConfig->updateConfigByName('beian', $data['beian']);
        }
        session()->flash('success', '编辑成功');
        return back();
    }
}
