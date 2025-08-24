<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|max:225|unique:user_accounts,name',
            'image' => 'image|mimes:png,jpg,gif|max:2048',
            'about' => 'string|max:60'
        ];
    }

    public function messgaes(){
        return [
            'name.required' => 'name should be require',
            'name.unique' => 'this name is already taken',
            'image.max' => 'image should not be more than 2Mb',
            'about.max' => 'text should not be more than 60 letters'
        ];
    }
}
