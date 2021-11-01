<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'phone' => ['required', 'digits:10', 'starts_with:0', 'unique:users,phone',],
            'password' => ['required', 'confirmed', 'min:6',],
            'name' => ['required',],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if(isset($this->name) && $this->name != null)
        {
            $this->merge([
                'name' => preg_replace( "/\s+/", " ", $this->name),
            ]);
        }
    }
}
