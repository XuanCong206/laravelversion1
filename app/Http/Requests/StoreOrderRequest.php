<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'total_amount'=>'numeric',

            // Quy tắc cho sản phẩm 
            'products' => 'required|array',  // Đảm bảo 'products' là một mảng
            'products.*.id' => 'required|exists:products,id',  // Mỗi sản phẩm phải có 'id' hợp lệ
            'products.*.quantity' => 'required|integer|min:1',  // Số lượng sản phẩm phải là số nguyên và >= 1
            'products.*.price_motion' => 'nullable|numeric',  // Giá khuyến mãi có thể không có, nhưng nếu có thì phải là số
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Bạn chưa nhập vào email.',
            'email.email' => 'Email chưa đúng định dạng. Ví dụ: abc@gmail.com',
            'email.unique' => 'Email đã tồn tại. Hãy chọn email khác',
            'email.string' => 'Email phải là dạng ký tự',
            'email.max' => 'Độ dài email tối đa 191 ký tự',
            'name.required' => 'Bạn chưa nhập Họ Tên',
            'name.string' => 'Họ Tên phải là dạng ký tự',
            'phone.required'=> 'Bạn chưa nhập Số điện thoại',

            // Thông báo cho sản phẩm
            'products.required' => 'Bạn phải chọn ít nhất một sản phẩm.',
            'products.*.id.required' => 'Mã sản phẩm là bắt buộc.',
            'products.*.id.exists' => 'Sản phẩm không tồn tại.',
            'products.*.quantity.required' => 'Bạn phải nhập số lượng cho sản phẩm.',
            'products.*.quantity.integer' => 'Số lượng sản phẩm phải là một số nguyên.',
            'products.*.quantity.min' => 'Số lượng sản phẩm phải ít nhất là 1.',
            'products.*.price_motion.numeric' => 'Giá khuyến mãi phải là một số.',
         
        ];
    }
}
