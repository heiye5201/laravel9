<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class AdvSpacesRequest extends BaseRequest
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
            'name' => ['required', 'min:3', 'max:255'],
            'width' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'local_type' => ['required', 'string', Rule::in(['home_banner', 'class_banner', 'wap_banner'])],
        ];
    }
}
