<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Stores\Admin\UserStore;

class UserController extends Controller
{
    protected $objStoreUser;

    public function __construct()
    {
        $this->objStoreUser = new UserStore();
    }

    /**
     * 用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->objStoreUser->getAllUsers();

        return view('admin.user.index', compact('users'));
    }

    /**
     * 修改用户状态
     * @param $uid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($uid)
    {
        $user = $this->objStoreUser->getUserById($uid);
        if (!$user) {
            return back()->with('danger','参数传递错误');
        }
        if ($user->user_status) {
            if ($this->objStoreUser->forbidden($uid)) {
                return back()->with('success','禁用成功');
            } else {
                return back()->with('danger','禁用失败');
            }
        } else {
            if ($this->objStoreUser->enable($uid)) {
                return back()->with('success','启用成功');
            } else {
                return back()->with('danger','启用失败');
            }
        }
    }
}
