<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchReportRequest extends FormRequest
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
            //
            'reported_start_date'   => 'nullable|date',
            'reported_end_date'     => 'nullable|date|exclude_without:reported_start_date|after_or_equal:reported_start_date',
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date|exclude_without:start_date|after_or_equal:start_date',
            'completed_start_date'  => 'nullable|date',
            'completed_end_date'    => 'nullable|date|exclude_without:completed_start_date|after_or_equal:completed_start_date',
        ];
    }
    public function attributes()
    {
        return [
            'reported_start_date'   => '報告日(開始)',
            'reported_end_date'     => '報告日(終了)',
            'start_date'            => '対応予定期間(開始)',
            'end_date'              => '対応予定期間(終了)',
            'completed_start_date'  => '完了日(開始)',
            'completed_end_date'    => '完了日(終了)',
        ];
    }
}
