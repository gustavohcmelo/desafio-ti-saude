<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;

class EspecialidadeRequest extends FormRequest
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
            'espec_nome' => 'required|max:150',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //should use if you want custom or translate the messages
        ];
    }
}
