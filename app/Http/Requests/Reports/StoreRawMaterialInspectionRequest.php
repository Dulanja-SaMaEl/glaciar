<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class StoreRawMaterialInspectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'supplier' => 'required|string|max:200',
            'material_type' => 'required|string|max:100',
            'quantity_received' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'clearness' => 'required|in:Pass,Fail',
            'odor' => 'required|in:Normal,Abnormal',
            'without_damages' => 'required|in:Yes,No',
            'free_from_particles' => 'required|in:Yes,No',
            'comments' => 'nullable|string',
            'checked_by' => 'required|string|max:100',
            'overall_result' => 'required|in:Accepted,Rejected,Accepted with condition',
        ];
    }
}