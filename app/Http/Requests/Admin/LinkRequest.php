<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
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
        $id = $this->route('link') ? $this->route('link')->id : 0;
        return [
            'name' => 'required|unique:la_link,name,'.$id,
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '链接名称不能为空',
            'name.unique' => '链接名称已经存在',
            'url.required' => '请填写链接地址'
        ];
    }
}
