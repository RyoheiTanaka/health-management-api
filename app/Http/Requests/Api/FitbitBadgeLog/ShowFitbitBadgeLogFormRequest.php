<?php

namespace App\Http\Requests\Api\FitbitBadgeLog;

use Illuminate\Foundation\Http\FormRequest;

class ShowFitbitBadgeLogFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fitbit_badge_log_id' => ['required', 'integer', 'exists:fitbit_badge_logs,id,deleted_at,NULL'],
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return array_merge(
            $this->all(),
            [
                'fitbit_badge_log_id' => $this->fitbitBadgeLogId
            ]
        );
    }
}
