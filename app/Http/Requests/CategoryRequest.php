<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $categoryId = $this->route('category')?->id ?? $this->route('category');

        return [
            'name' => 'required|string|max:191|unique:categories,name,'.$categoryId,
            'status' => 'required|in:Active,Inactive',
        ];
    }
}
