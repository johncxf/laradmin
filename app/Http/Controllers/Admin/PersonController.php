<?php

namespace App\Http\Controllers\Admin;

use App\Stores\Admin\PersonStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonController extends AdminBaseController
{
    protected $objStorePerson;
    public function __construct()
    {
        parent::__construct();
        $this->objStorePerson = new PersonStore();
    }

    // 个人信息
    public function index()
    {
        $admin_id = $this->getUserId('admin');
        $admin = $this->objStorePerson->getAdminInfo($admin_id);
        return view('admin.person',compact('admin'));
    }
    // 修改密码
    public function reset(Request $request)
    {
        $data = $this->validate(($request), [
            'password' => 'required|between:6,20|confirmed|alpha_dash'
        ],[
            'password.required' => '请输入密码',
            'password.between' => '请输入6-16位密码',
            'password.confirmed' => '两次输入密码不同',
            'password.alpha_dash' => '密码只能由字母、数字、(-)和(_)组成',
        ]);
        $password = bcrypt($data['password']);
        if ($this->objStorePerson->resetPassword($password, auth('admin')->id())){
            session()->flash('success', '修改密码成功');
            return back();
        } else {
            session()->flash('warning', '修改密码失败');
            return back();
        }
    }
    // 修改资料
    public function update(Request $request)
    {
        $id = auth('admin')->id();
        $data = $this->validate(($request), [
            'mobile' => 'required|regex:/^1[345678][0-9]{9}$/|unique:la_admin,mobile,'.$id,
            'email' => 'required|email|unique:la_admin,email,'.$id,
        ],[
            'mobile.required' => '请填写手机号',
            'mobile.regex' => '手机号格式错误',
            'mobile.unique' => '手机号已经存在',
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误',
            'email.unique' => '邮箱已经存在',
        ]);
        $path = $request->file('avatar')->store('admin/avatars', 'public');
        if ($path) {
            $data['avatar'] = 'storage/'.$path;
        }
        if ($this->objStorePerson->updateAdminInfo($data, $id)) {
            session()->flash('success', '修改资料成功');
            return back();
        } else {
            session()->flash('warning', '修改资料失败');
            return back();
        }
    }
}
