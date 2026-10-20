<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class StorePestControlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date|before_or_equal:today',
            'tube_well' => 'required|in:Clear,Issue,N/A',
            'storage_tank_area' => 'required|in:Clear,Issue,N/A',
            'filter_room' => 'required|in:Clear,Issue,N/A',
            'filling_room' => 'required|in:Clear,Issue,N/A',
            'raw_material_store' => 'required|in:Clear,Issue,N/A',
            'finish_product_store' => 'required|in:Clear,Issue,N/A',
            'washing_area_19l' => 'required|in:Clear,Issue,N/A',
            'office_area' => 'required|in:Clear,Issue,N/A',
            'factory_entrance' => 'required|in:Clear,Issue,N/A',
            'lunch_room' => 'required|in:Clear,Issue,N/A',
            'comments' => 'nullable|string',
            'checked_by' => 'required|string|max:100',
        ];
    }
}