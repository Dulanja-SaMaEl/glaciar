<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'session_date' => 'required|date',
            'session_title' => 'required|string|max:200',
            'session_duration' => 'required|string|max:50',
            'trainer_name' => 'required|string|max:100',
            'attendees' => 'required|array|min:1',
            'attendees.*.name' => 'required|string|max:100',
            'attendees.*.designation' => 'required|string|max:100',
        ];
    }
}