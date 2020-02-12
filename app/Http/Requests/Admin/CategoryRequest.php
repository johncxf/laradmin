<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $id = $this->route('category') ? $this->route('category')->id : 0;
        return [
            'name' => 'required|unique:la_category,name,'.$id,
            'alias' => 'required|unique:la_category,alias,'.$id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '栏目名称不能为空',
            'name.unique' => '栏目名称已经存在',
            'alias.required' => '栏目别名不能为空',
            'alias.unique' => '栏目别名已经存在'
        ];
    }
}
