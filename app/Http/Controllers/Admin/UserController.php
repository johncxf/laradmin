<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Stores\Admin\UserStore;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $objStoreUser;

    public function __construct()
    {
        $this->objStoreUser = new UserStore();
    }

    /**
     * 本站用户列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $where = array();
        if ($request['uid'] && $request['uid'] !== null) {
            $where[] = ['id', '=', $request['uid']];
        }
        if ($request['nickname'] && $request['nickname'] !== null) {
            $where[] = ['nickname', 'like', '%'.$request['nickname'].'%'];
        }
        if ($request['user_status'] !== null && $request['user_status'] != -1) {
            $where[] = ['user_status', '=', $request['user_status']];
        }
        if ($request['user_type']) {
            $where[] = ['user_type', '=', $request['user_type']];
        }

        $users = $this->objStoreUser->getAllUsers($where);

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

    public function oauthUser(Request $request)
    {
        $where = array();
        if ($request['uid'] && $request['uid'] !== null) {
            $where[] = ['uid', '=', $request['uid']];
        }
        if ($request['name'] && $request['name'] !== null) {
            $where[] = ['name', 'like', '%'.$request['name'].'%'];
        }
        if ($request['status'] !== null && $request['status'] != -1) {
            $where[] = ['status', '=', $request['status']];
        }
        if ($request['from']) {
            $where[] = ['from', '=', $request['from']];
        }

        $users = $this->objStoreUser->getOauthUser($where);

        return view('admin.user.oauthuser', compact('users'));
    }
}
