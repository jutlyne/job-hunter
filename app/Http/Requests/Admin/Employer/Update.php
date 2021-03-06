<?php

namespace App\Http\Requests\Admin\Employer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class Update extends FormRequest
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
            'name' => 'required|max:50',
            'email' => 'required',
            'slug' => 'required',
            'thumbnail' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'nullable',
            'phone' => 'nullable',
            'password' => 'nullable|min:6',
            'province_id' => 'required',
            'address' => 'required',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if(isset($this->description) && $this->description != null)
        {
            $this->merge([
//                'description' => preg_replace(['/^((?:&nbsp;|\s)+)$/', '/\s*&nbsp;(?:\s*&nbsp;)*\s*/', '/\s+/'], " ", $this->description),
            ]);
        }

        if(isset($this->name) && $this->name != null)
        {
            $this->merge([
                'name' => preg_replace( "/\s+/", " ", $this->name),
            ]);
        }

        if(isset($this->address) && $this->address != null)
        {
            $this->merge([
                'address' => preg_replace( "/\s+/", " ", $this->address),
            ]);
        }
        
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
}
