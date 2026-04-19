<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class StoreTankCleaningRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'tank_number' => 'required|string|max:20',
            'frequency' => 'required|in:Daily,Weekly,Monthly,Quarterly,As Needed',
            'cleaned' => 'required|in:Yes,No,Partial',
            'cleaning_method' => 'nullable|string|max:255',
            'chemical_used' => 'nullable|string|max:255',
            'comments' => 'nullable|string',
            'checked_by' => 'required|string|max:100',
        ];
    }
}