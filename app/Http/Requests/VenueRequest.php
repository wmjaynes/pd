<?php

namespace App\Http\Requests;

use App\Venue;
use Illuminate\Foundation\Http\FormRequest;

class VenueRequest extends FormRequest
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
            'addressLocality' => 'required',
            'addressRegion' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'addressLocality.required' => 'The city field is required.',
            'addressRegion.required' => 'The state field is required.',
        ];
    }

    public function addressIsNotUnique()
    {
        $streetAddress = $this->input('streetAddress');
        $addressLocality = $this->input('addressLocality');
        $addressRegion = $this->input('addressRegion');
        $venues = Venue::visible()->where('streetAddress', $streetAddress)->
            where('addressLocality', $addressLocality)->
            where('addressRegion', $addressRegion)->get();
        if ($venues->isEmpty())
            return false;
        else return true;
    }

    public function nameIsNotUnique()
    {
        $name = $this->input('name');
        $venues = Venue::where('name', $name)->where('visible', 1)->get();
        if ($venues->isEmpty())
            return false;
        else return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->nameIsNotUnique()) {
                $validator->errors()->add('name', 'The name already exists in the list of venues.');
            }
            if ($this->addressIsNotUnique()) {
                $validator->errors()->add('address', 'The address already exists in the list of venues.');
            }
        });
    }
}
