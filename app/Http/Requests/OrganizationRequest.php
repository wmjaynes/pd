<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
            'name' => 'required|min:5',
            'email' => 'required|email',
            'url' => 'nullable|url',
            'logoUrl' => 'nullable|url',
            'facebookUrl' => 'nullable|url',

        ];
    }

    public function messages()
    {
        return [
            'url.url' => 'The web address format is invalid',
            'facebookUrl' => 'The Facebook address format is invalid',
            'logoUrl.url' => 'The logo image address format is invalid',
        ];
    }
}
