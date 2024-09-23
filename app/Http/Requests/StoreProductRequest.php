<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'slug' => 'unique:products',
            'price' => 'required|numeric',
            // 'price_motion' => 'numeric',
            'short_desc' => 'required|string',
            'desc' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên Sản phẩm',
            'name.string' => 'Họ Tên phải là dạng ký tự',
            'slug.unique' => 'Slug đã tồn tại. Hãy thử lại.',
            'price.required' => 'Bạn chưa nhập giá sản phẩm',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'short_desc.required' => 'Bạn chưa mô tả ngắn ngắn',
            'desc.required' => 'Bạn chưa mô tả ngắn ngắn',
            
        ];
    }

     
}

