<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyCleaningRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'shift' => 'required|in:Morning,Afternoon,Evening,Night',
            'fe_floor' => 'required|in:Done,Not Done,N/A',
            'fe_windows' => 'required|in:Done,Not Done,N/A',
            'fe_door' => 'required|in:Done,Not Done,N/A',
            'fe_cupboard' => 'required|in:Done,Not Done,N/A',
            'fe_foot_bath' => 'required|in:Done,Not Done,N/A',
            'fa_wall' => 'required|in:Done,Not Done,N/A',
            'fa_floor' => 'required|in:Done,Not Done,N/A',
            'fa_roof' => 'required|in:Done,Not Done,N/A',
            'st_wall' => 'required|in:Done,Not Done,N/A',
            'fill_wall' => 'required|in:Done,Not Done,N/A',
            'fill_floor' => 'required|in:Done,Not Done,N/A',
            'fill_roof' => 'required|in:Done,Not Done,N/A',
            'fill_table' => 'required|in:Done,Not Done,N/A',
            'fill_taps' => 'required|in:Done,Not Done,N/A',
            'fill_pipes' => 'required|in:Done,Not Done,N/A',
            'general_comments' => 'nullable|string',
            'checked_by' => 'required|string|max:100',
        ];
    }
}