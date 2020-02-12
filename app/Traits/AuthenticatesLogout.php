<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/1/28
 * @Time: 12:59
 */

namespace App\Traits;


use Illuminate\Http\Request;

trait AuthenticatesLogout
{
    public function logout(Request $request)
    {
        $this->guard()->logout();

        // 获取session的name
        $session_name = $request->session()->getName();
        // 删除数据
        $request->session()->forget($session_name);
        // 重新生成 session ID
        $request->session()->regenerate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}