<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        $role = $this->route('role');
        $id = $role ? $role->id : null;
        return [
            'name' => 'required|between:2,20|unique:la_role,name,'.$id,
            'status' => 'required|integer'
        ];
    }

    /**
     * 自定义错误信息
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '角色名称不能为空',
            'name.between:2,20' => '名称需要2到20个字符之间',
            'name.unique' => '角色名称不能重复',
            'status.required' => '请选择角色状态',
            'status.integer' => '角色状态需传递int类型参数'
        ];
    }
}
