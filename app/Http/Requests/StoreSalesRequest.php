<?php

namespace App\Http\Requests;

use App\Models\SalesRecord;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreSalesRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Auth:sanctum middleware protects this route.
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],

            'cases_500ml' => ['required', 'integer', 'min:0'],
            'cases_1000ml' => ['required', 'integer', 'min:0'],
            'cases_1500ml' => ['required', 'integer', 'min:0'],
            'cases_5000ml' => ['required', 'integer', 'min:0'],

            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $sum =
                (int) $this->input('cases_500ml', 0) +
                (int) $this->input('cases_1000ml', 0) +
                (int) $this->input('cases_1500ml', 0) +
                (int) $this->input('cases_5000ml', 0);

            if ($sum <= 0) {
                $validator->errors()->add('cases', 'At least one case quantity must be greater than 0.');
            }

            $user = $this->user();
            $repId = $user?->rep?->id;
            if (!$repId) {
                $validator->errors()->add('rep_id', 'Rep profile not available for this user.');
                return;
            }

            $date = $this->input('date');
            if (!$date) {
                return;
            }

            $exists = SalesRecord::query()
                ->where('rep_id', $repId)
                ->where('date', $date)
                ->exists();

            if ($exists) {
                $validator->errors()->add('date', 'You already submitted sales for this date.');
            }
        });
    }
}

