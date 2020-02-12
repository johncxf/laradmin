<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $admin = $this->route('admin');
        $id = $admin ? $admin : null;

        return [
            'username' => 'required|between:2,20|unique:la_admin,username,'.$id,
            'mobile' => 'required|regex:/^1[345678][0-9]{9}$/|unique:la_admin,mobile,'.$id,
            'email' => 'required|email|unique:la_admin,email,'.$id,
            'password' => 'required|between:6,20|confirmed|alpha_dash'
        ];
    }

    /**
     * 自定义错误信息
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.between:2,20' => '用户名需要2到20个字符之间',
            'username.unique' => '用户名不能重复',
            'mobile.required' => '请填写手机号',
            'mobile.regex' => '手机号格式错误',
            'mobile.unique' => '手机号已经存在',
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式错误',
            'email.unique' => '邮箱已经存在',
            'password.required' => '请填写密码',
            'password.between' => '请输入6-16位密码',
            'password.confirmed' => '两次输入密码不同',
            'password.alpha_dash' => '密码只能由字母、数字、(-)和(_)组成',
        ];
    }
}
