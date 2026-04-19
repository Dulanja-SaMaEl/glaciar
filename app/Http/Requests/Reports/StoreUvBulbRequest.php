<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class StoreUvBulbRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'bulb_id' => 'required|string|max:20',
            'bulb_location' => 'required|string|max:100',
            'start_time' => 'required|date_format:H:i',
            'finish_time' => 'required|date_format:H:i|after:start_time',
            'comments' => 'nullable|string',
            'checked_by' => 'required|string|max:100',
        ];
    }
}