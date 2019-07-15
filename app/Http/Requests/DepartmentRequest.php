<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'min:5'],
            'description' => ['max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute không được để trống',
            'name.string' => ':attribute phải là ký tự',
            'name.max' => ':attribute tối đa được :max ký tự',
            'name.min' => ':attribute tối thiêu :min ký tự',
            'description.max' => ':attribute tối đa được :max ký tự',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên phòng ban',
            'description' => 'Mô tả',
        ];
    }
}
