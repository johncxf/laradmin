<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminRequest;
use App\Stores\Admin\AdminStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $objStoreAdmin;

    public function __construct()
    {
        $this->objStoreAdmin = new AdminStore();
    }
    /**
     * 管理员列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 所有管理员
        $admins = $this->objStoreAdmin->getAllAdmins(10);
        // 获取所有角色信息
        $roles = $this->objStoreAdmin->getAllRoles();

        return view('admin.admin.index', compact('admins', 'roles'));
    }

    /**
     * 添加管理员
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $data = [
            'username' => $request->username,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
            'create_at' => date('Y-m-d H:i:s', time()),
        ];
        $data['password'] = bcrypt($data['password']);
        $roleIds = [];
        if (isset($request->roleid) && !empty($request->roleid)) {
            $roleIds = $request->roleid;
        }
        if ($this->objStoreAdmin->addAdmin($data, $roleIds)) {
            session()->flash('success', '添加成功');
            return back();
        } else {
            session()->flash('warning', '添加失败');
            return back();
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
     * 编辑管理员页面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 获取所有角色信息
        $roles = $this->objStoreAdmin->getAllRoles();
        // 获取管理员信息
        $admin = $this->objStoreAdmin->getAdminInfo($id);
        // 获取自己所属角色id
        $role_ids = $this->objStoreAdmin->getMyRoleIds($id);

        return view('admin.admin.edit', compact('roles', 'admin', 'role_ids'));
    }

    /**
     * 更新管理员信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate(($request), [
            'mobile' => 'required|regex:/^1[345678][0-9]{9}$/|unique:la_admin,mobile,'.$id,
            'email' => 'required|email|unique:la_admin,email,'.$id,
            'password' => 'nullable|between:6,20|confirmed|alpha_dash'
        ],[
            'mobile.required' => '请填写手机号',
            'mobile.regex' => '手机号格式错误',
            'mobile.unique' => '手机号已经存在',
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误',
            'email.unique' => '邮箱已经存在',
            'password.between' => '请输入6-16位密码',
            'password.confirmed' => '两次输入密码不同',
            'password.alpha_dash' => '密码只能由字母、数字、(-)和(_)组成',
        ]);
        if (!isset($id) && !is_int($id)) {
            session()->flash('danger', '参数传递错误！');
            return back();
        }
        $data = [
            'mobile' => $request->mobile,
            'email' => $request->email,
            'update_at' => date('Y-m-d H:i:s', time()),
        ];
        if (isset($request->password) && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }
        $roleIds = [];
        if (isset($request->roleid) && !empty($request->roleid)) {
            $roleIds = $request->roleid;
        }
        $ret = $this->objStoreAdmin->updateAdmin($data, $id, $roleIds);
        if ($ret) {
            session()->flash('success', '编辑成功');
            return back();
        } else {
            session()->flash('warning', '编辑失败');
            return back();
        }
    }

    /**
     * 删除管理员
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->objStoreAdmin->deleteAdmin($id);
        if ($delete) {
            session()->flash('success', '删除成功');
            return back();
        } else {
            session()->flash('danger', '删除失败');
            return back();
        }
    }

    /**
     * 启用管理员
     * @param $id
     * @return array
     */
    public function enable($id)
    {
        $result = array('state' => '', 'info' => '', 'referer' => '');
        if ($this->objStoreAdmin->enable($id)) {
            $result['state'] = 'success';
            $result['info'] = '管理员启用成功！';
            return $result;
        } else {
            $result['state'] = 'fail';
            $result['info'] = '管理员启用失败！';
            return $result;
        }
    }

    /**
     * 禁用管理员
     * @param $id
     * @return array
     */
    public function forbidden($id)
    {
        $result = array('state' => '', 'info' => '', 'referer' => '');
        if ($this->objStoreAdmin->forbidden($id)) {
            $result['state'] = 'success';
            $result['info'] = '管理员禁用成功！';
            return $result;
        } else {
            $result['state'] = 'fail';
            $result['info'] = '管理员禁用失败！';
            return $result;
        }
    }

}
