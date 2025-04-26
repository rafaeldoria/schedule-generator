<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleDetailsRequest extends FormRequest
{
    private const REGEX_TIME = 'regex:/^([01]?[0-9]|2[0-3]):([0-5]?[0-9]):([0-5]?[0-9])$/';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'string'],
            'time' => ['required', self::REGEX_TIME],
            'schedule_id' => ['required', 'integer', 'min:1'],
            'full_name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'email'],
            'cellphone' => ['nullable', 'string'],
        ];
    }
}
