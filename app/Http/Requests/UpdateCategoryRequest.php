<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'category_name' => 'required',
            'parent_id' => 'required',
            'url' => 'required',
            'desc' => 'sometimes',
            'meta_title' => 'sometimes',
            'meta_description' => 'sometimes',
            'meta_keywords' => 'sometimes',
            'meta_desc' => 'sometimes',
            'category_discount' => 'sometimes',
        ];
    }
}
