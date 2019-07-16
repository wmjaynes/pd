<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        return ['name' => 'required|min:5', 'xstartDate' => 'required|date', 'xendDate' => 'required|date|after_or_equal:xstartDate', //            'startTime' => 'required|date_format:H:i',
//            'endTime' => 'required|date_format:hh[.:]MM space? meridian',
            'email' => 'email|nullable', 'url' => 'nullable|url', 'imageUrl' => 'nullable|url', 'flyerUrl' => 'nullable|url', 'ticketUrl' => 'nullable|url', 'facebookUrl' => 'nullable|url', 'altMapUrl' => 'nullable|url', 'startTime' => 'required', 'endTime' => 'required',

        ];
    }

    public function messages()
    {
        return ['url.url' => 'The web address format is invalid', 'facebookUrl' => 'The Facebook event address format is invalid', 'imageUrl.url' => 'The image address format is invalid', 'flyerUrl.url' => 'The flyer address format is invalid', 'ticketUrl.url' => 'The ticket address format is invalid', 'altMapUrl.url' => 'The alternate map address format is invalid', 'xstartDate.required' => 'The start date field is required.', 'xendDate.required' => 'The end date field is required.', 'xstartDate.date' => 'The start date format is invalid.', 'xendDate.date' => 'The end date format is invalid.', 'xendDate.after_or_equal' => 'The end date must be a date after the start date.',

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errors = $validator->errors();

            Log::debug("startTime: ".$this->startTime);

            if (!$errors->has('startTime'))
                if (!preg_match('/^(1[0-2]|0?[1-9]):[0-5][0-9] (AM|PM)$/i', $this->startTime))
                    $validator->errors()->add('startTime', 'The start time is not a valid format.');
            if (!$errors->has('endTime'))
                if (!preg_match('/^(1[0-2]|0?[1-9]):[0-5][0-9] (AM|PM)$/i', $this->endTime))
                    $validator->errors()->add('endTime', 'The end time is not a valid format.');

            if ($errors->has('xstartDate') or $errors->has('xendDate'))
                return;

            $start = new Carbon ($this->xstartDate . ' ' . $this->startTime);
            $end = new Carbon ($this->xendDate . ' ' . $this->endTime);

            if ($end->lte($start))
                $validator->errors()->add('endTime', 'The end time must be a time after the start time.');

        });
    }
}
