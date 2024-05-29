<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AreasRequest extends BaseRequest
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
            'name'  => ['required', 'string', 'max:255'],
            'code' => ['required', 'string'],
            'pid' => ['required', 'numeric'],
            'deep' => ['required', 'numeric'],
        ];
    }
}
