<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use App\Stores\Admin\RoleStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $objStoreRole;

    public function __construct()
    {
        $this->objStoreRole = new RoleStore();
    }
    /**
     * 角色列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 获取所有角色信息
        $roles = $this->objStoreRole->getAllRole();

        return view('admin.role.index', ['roles' => $roles]);
    }

    /**
     * 添加角色
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RoleRequest $request)
    {
        $data = [
            'name' => $request->name,
            'status' => $request->status,
            'create_time' => date('Y-m-d H:i:s', time()),
            'listorder' => 0,
        ];
        if (isset($request->remark)) {
            $data['remark'] = $request->remark;
        }
        $add_res = $this->objStoreRole->addRole($data);
        if ($add_res === true) {
            session()->flash('success', '添加成功');
            return back();
        } else {
            session()->flash('danger', '添加失败');
            return back();
        }
    }

    /**
     *  修改角色信息
     * @param RoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $data = [
            'name' => $request->name,
            'remark' => $request->remark,
            'status' => $request->status,
            'update_time' => date('Y-m-d H:i:s', time()),
        ];
        $res = $role->update($data);
        if ($res === true) {
            session()->flash('success', '编辑成功');
            return back();
        } else {
            session()->flash('danger', '编辑失败');
            return back();
        }
    }

    /**
     * 删除角色
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$id) {
            session()->flash('danger', '参数传递错误！');
            return back();
        }
        if ($this->objStoreRole->deleteRole($id) === true) {
            session()->flash('success', '删除成功！');
            return back();
        } else {
            session()->flash('danger', '删除失败！');
            return back();
        }
    }

    /**
     * 角色授权页面
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function permission(Role $role)
    {
        $permission_menus = $this->objStoreRole->getPermissionMenus($role->id);

        return view('admin.role.permission', compact('role', 'permission_menus'));
    }

    /**
     * 角色授权
     * @param Request $request
     * @return array
     */
    public function permissionStore(Request $request)
    {
        $role_id = $request->role_id;
        $result = array('state' => '', 'info' => '', 'referer' => '/admin/role/permission/'.$role_id);
        if (!$role_id) {
            $result['state'] = 'fail';
            $result['info'] = '参数传递错误';
            return $result;
        }
        $menu_ids = $request->menuid;
        if (is_array($menu_ids) && count($menu_ids) > 0) {
            $this->objStoreRole->deleteAuth($role_id);
            foreach ($menu_ids as $menu_id) {
                $menu = $this->objStoreRole->getMenu($menu_id);
                if ($menu) {
                    $permission = $menu->permission;
                    $this->objStoreRole->addAccess(['role_id' => $role_id, 'rule_name' => $permission]);
                }
            }
            $result['state'] = 'success';
            $result['info'] = '授权成功！';
            return $result;
        } else {
            // 当没有数据时，清除当前角色授权
            $this->objStoreRole->deleteAuth($role_id);
            $result['state'] = 'success';
            $result['info'] = '清除角色权限成功';
            return $result;
        }
    }


}
