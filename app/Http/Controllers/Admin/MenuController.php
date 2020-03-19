<?php

namespace App\Http\Controllers\Admin;

use App\Stores\Admin\MenuStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    protected $objStoreMenu;

    public function __construct()
    {
        $this->objStoreMenu = new MenuStore();
    }
    /**
     * 后台菜单页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 获取菜单
        $menus = $this->objStoreMenu->getAllMenus();

        return view('admin.menu.index', ['menus' => $menus]);

    }

    /**
     * 添加菜单页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $parentId = 0;
        if (isset($request->parentid)) {
            $parentId = $request->parentid;
        }

        $select_menus = $this->objStoreMenu->selectMenus($parentId);

        return view('admin.menu.create', ['select_menus' => $select_menus]);
    }

    /**
     * 添加菜单操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // 参数验证
        $params = $this->validate(($request), [
            'parentId' => 'required|integer',
            'name' => 'required',
            'permission' => 'required|unique:la_menu,permission'
        ]);
        $data = [
            'parentId' => $params['parentId'],
            'name' => $params['name'],
            'url' => '',
            'permission' => $params['permission'],
            'module' => 'admin',
            'icon' => 'far fa-circle',
            'type' => 1,
            'status' => 1,
            'remark' => '',
            'sort' => 0,
        ];
        if (isset($request->icon) && !empty($request->icon)) {
            $data['icon'] = $request->icon;
        }
        if (isset($request->type)) {
            $data['type'] = (int)$request->type;
        }
        if (isset($request->status)) {
            $data['status'] = (int)$request->status;
        }
        if (isset($request->sort)) {
            $data['sort'] = (int)$request->sort;
        }
        if (isset($request->remark)) {
            $data['remark'] = $request->remark;
        }
        if (isset($request->url)) {
            $data['url'] = $request->url;
        }
        $add_res = $this->objStoreMenu->storeMenu($data);
        if ($add_res === true) {
            session()->flash('success', '添加成功');
            return redirect()->route('menu.index');
        } else {
            session()->flash('danger', '添加失败');
            return back();
        }
    }

    /**
     * 编辑用户页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 参数校验
        if (!isset($id) && empty($id)) {
            session()->flash('danger', '参数传递错误');
            return back();
        }
        $menu = $this->objStoreMenu->getMenuInfo($id);
        if (!$menu) {
            session()->flash('danger', '参数传递错误');
            return back();
        }
        $parentId = $menu->parentId;

        $select_menus = $this->objStoreMenu->selectMenus($parentId);

        return view('admin.menu.edit', ['menu' => $menu, 'select_menus' => $select_menus]);
    }

    /**
     * 编辑菜单
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (!isset($id) || empty($id)) {
            session()->flash('danger', '参数传递错误');
            return back();
        }
        // 参数验证
        $params = $this->validate(($request), [
            'parentId' => 'required|integer',
            'name' => 'required',
        ]);
        $data = [
            'parentId' => $params['parentId'],
            'name' => $params['name'],
            'url' => '',
            'module' => 'admin',
            'icon' => 'far fa-circle',
            'type' => 1,
            'status' => 1,
            'remark' => '',
            'sort' => 0,
        ];
        if (isset($request->icon) && !empty($request->icon)) {
            $data['icon'] = $request->icon;
        }
        if (isset($request->type)) {
            $data['type'] = (int)$request->type;
        }
        if (isset($request->status)) {
            $data['status'] = (int)$request->status;
        }
        if (isset($request->sort)) {
            $data['sort'] = (int)$request->sort;
        }
        if (isset($request->remark)) {
            $data['remark'] = $request->remark;
        }
        if (isset($request->url)) {
            $data['url'] = $request->url;
        }
        $update = $this->objStoreMenu->updateMenu($id, $data);
        if ($update) {
            session()->flash('success', '编辑成功');
            return back();
        } else {
            session()->flash('danger', '编辑失败');
            return back();
        }
    }

    /**
     * 删除菜单
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $result = array('state' => '', 'info' => '', 'referer' => '');
        if ($this->objStoreMenu->deleteMenu($id)) {
            $result['state'] = 'success';
            $result['info'] = '删除成功！';
            return $result;
        } else {
            $result['state'] = 'fail';
            $result['info'] = '删除失败！';
            return $result;
        }
    }

    /**
     * 同步菜单
     * @return array
     */
    public function synchro()
    {
        $result = array('state' => '', 'info' => '', 'referer' => '');
        $config_menus = config('menu');
        if (!$config_menus) {
            $result['state'] = 'fail';
            $result['info'] = '同步失败！';
            return $result;
        }
        $ret = $this->objStoreMenu->synchro($config_menus,'admin');
        if (empty($ret)) {
            $result['state'] = 'success';
            $result['info'] = '同步成功！';
            return $result;
        } else {
            $result['state'] = 'fail';
            $result['info'] = '同步失败！';
            return $result;
        }
    }
}
