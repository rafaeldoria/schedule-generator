<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    private const REGEX_TIME = 'regex:/^([01]?[0-9]|2[0-3]):([0-5]?[0-9]):([0-5]?[0-9])$/';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recurrence' => 'required',
            'startTime' => ['required', self::REGEX_TIME],
            'endTime' => ['required', self::REGEX_TIME],
            'duration' => ['required', 'integer', 'min:1'],
            'saturdayOff' => ['nullable', 'boolean'],
            'break' => ['nullable', 'array', 'min:1'],
            'break.*.startBrake' => ['required_with:break.*.endBrake', self::REGEX_TIME],
            'break.*.endBrake' => ['required_with:break.*.startBrake', self::REGEX_TIME],
        ];
    }
}
