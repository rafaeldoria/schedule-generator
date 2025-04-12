<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleGeneratorRequest extends FormRequest
{
    private const REGEX_TIME = 'regex:/^([01]?[0-9]|2[0-3]):([0-5]?[0-9])$/';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recurrence' => 'required|integer',
            'start_time' => ['required', self::REGEX_TIME],
            'end_time' => ['required', self::REGEX_TIME],
            'duration' => ['required', 'integer', 'min:1'],
            'saturday_off' => ['nullable', 'boolean'],
            'breaks' => ['nullable', 'array', 'min:1'],
            'breaks.*.start_time' => ['required_with:break.*.end_time', self::REGEX_TIME],
            'breaks.*.end_time' => ['required_with:break.*.start_time', self::REGEX_TIME],
        ];
    }
}
