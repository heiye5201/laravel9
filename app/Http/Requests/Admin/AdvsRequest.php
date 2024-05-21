<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AdvsRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pid' => ['required', 'numeric'],
            'url' => ['required', 'max:255'],
            'name' => ['required', 'min:3', 'max:255'],
            'is_type' => ['required', 'numeric'],
            'adv_start' => ['required', 'date'],
            'adv_end' => ['required', 'date'],
            'status' => ['required', 'boolean'],
            'is_sort' => ['required', 'numeric'],
            'image' => ['max:255'],
        ];
    }
}
