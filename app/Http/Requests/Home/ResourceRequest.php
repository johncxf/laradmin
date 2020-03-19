<?php

namespace App\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
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
        return [
            'title' => 'required|between:1,30',
            'type' => 'required|between:1,30',
            'item_id' => 'required|integer|min:1',
            'remark'=> 'required|between:1,128',
            'gold' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '资源名称不能为空',
            'title.between' => '资源名称应少于30字',
            'type.required' => '资源类型不能为空',
            'type.between' => '参数传递错误',
            'item_id.required' => '请选择所属分类',
            'item_id.integer' => '参数传递错误',
            'item_id.min' => '参数传递错误',
            'remark.required' => '请填写资源描述',
            'remark.between' => '资源描述不能多于128字',
            'gold.required' => '请填写资源所需积分'
        ];
    }
}
