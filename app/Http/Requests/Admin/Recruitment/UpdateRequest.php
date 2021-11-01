<?php

namespace App\Http\Requests\Admin\Recruitment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'slug' => ['required', 'max:255', Rule::unique('blogs')->ignore($this->id)],
            'preview_text' => ['required'],
            'benefit_text' => ['required'],
            'gender' => ['required', 'max:255'],
            'profile_text' => ['required'],
            'province_id' => ['required', 'max:255'],
            'category_id' => ['required', 'max:255'],
            'qty' => ['required'],
            'thumbnail' => $this->_method === 'PATCH' ? 'nullable' : '',
            'employer_id' => ['required']
        ];
    }
}
