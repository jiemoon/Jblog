<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
        $rules = [
            'title' => 'required|max:255|unique:articles',
            'summary' => 'required|max:255',
            'content' => 'required|min:100',
        ];

        if (request()->isMethod('put')) {
            $id = $this->segment(4);
            $rules['title'] = 'required|max:255|unique:articles,title,' . $id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title.unique' => '标题已存在',
            'title.max' => '标题长度不能超过255',
            'summary.required' => '摘要不能为空',
            'summary.max' => '摘要度不能超过255',
            'content.required' => '内容不能为空',
            'content.min' => '内容不能小于100个字',
        ];
    }
}
