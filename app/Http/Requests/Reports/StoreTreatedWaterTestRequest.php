<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatedWaterTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'test_time' => 'required',
            'tds' => 'required|numeric|min:0|max:9999',
            'ph' => 'required|numeric|min:0|max:14',
            'taste' => 'required|in:Normal,Abnormal',
            'odor' => 'required|in:Normal,Abnormal',
            'appearance' => 'required|in:Clear,Turbid,Colored,Other',
            'appearance_note' => 'nullable|string|max:255',
            'foreign_impurities' => 'required|in:None,Present',
            'sealing_quality' => 'required|in:Good,Defective,N/A',
            'sealing_notes' => 'nullable|string|max:255',
            'comments' => 'nullable|string',
            'checked_by' => 'required|string|max:100',
        ];
    }
}