<?php

namespace App\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class CreateRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->slug),
        ]);
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', 'unique:blogs'],
            'description' => ['required', 'max:255'],
            'content' => ['required'],
            'seo_title' => ['required', 'max:255'],
            'breadcrumb_seo_keyword' => ['required', 'max:40'],
            'seo_description' => ['required', 'max:255'],
            'seo_keyword' => ['required', 'max:255'],
            'category' => ['required'],
            'thumbnail' => $this->_method === 'PATCH' ? 'nullable' : 'required',
            'img_content' => ['nullable']
        ];
    }
}
