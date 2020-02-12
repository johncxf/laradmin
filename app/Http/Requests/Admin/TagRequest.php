<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
        $id = $this->route('tag') ? $this->route('tag')->id : 0;
        return [
            'name' => 'required|unique:la_tag,name,'.$id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '标签名称不能为空',
            'name.unique' => '标签名称已经存在'
        ];
    }
}
