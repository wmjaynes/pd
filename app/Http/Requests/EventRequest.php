<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'email' => 'email|nullable',
            'url' => 'nullable|url',
            'imageUrl' => 'nullable|url',
            'flyerUrl' => 'nullable|url',
            'ticketUrl' => 'nullable|url',
            'facebookUrl' => 'nullable|url',
            'altMapUrl' => 'nullable|url',

        ];
    }

    public function messages()
    {
        return [
            'url.url' => 'The web address format is invalid',
            'facebookUrl' => 'The Facebook event address format is invalid',
            'imageUrl.url' => 'The image address format is invalid',
            'flyerUrl.url' => 'The flyer address format is invalid',
            'ticketUrl.url' => 'The ticket address format is invalid',
            'altMapUrl.url' => 'The alternate map address format is invalid',
        ];
    }
}
