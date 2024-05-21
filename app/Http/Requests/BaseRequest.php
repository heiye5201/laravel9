<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'email',
        ];
    }

    /**
     * JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
     */
    protected function failedValidation(Validator $validator)
    {
        $errorData = $validator->errors();
        $info = collect($errorData)->first();
        $key = collect($errorData)->keys()->first();
        throw new HttpResponseException(
            response()->json([
                'code' => 500,
                'msg' => $key.' '.$info[0] ?? 'The given data was invalid.',
                'data' => $errorData,
            ], JsonResponse::HTTP_OK)
        );
    }
}
