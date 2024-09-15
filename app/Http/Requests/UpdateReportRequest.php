<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
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
            "status_id" => "sometimes|required|exists:statuses,id",
            "comment" => "nullable",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date|exclude_without:start_date|after_or_equal:start_date",
            "completed_at" => "nullable|required_if:status_id,4,5|prohibited_unless:status_id,4,5|date",
            "reason_id" => "nullable|required_if:status_id,5|prohibited_unless:status_id,5|exists:reasons,id",
        ];
    }
    public function attributes(): array
    {
        return [
            'status_id'     => '対応状況',
            'reason_id'     => '非対応理由',
            'comment'       => 'コメント',
            'start_date'    => '対応予定期間(開始)',
            'end_date'      => '対応予定期間(終了)',
            'schedule_lte'  => '対応予定期間',
            'completed_at'  => '対応完了日',
        ];
    }

    public function messages()
    {
        return [
            'completed_at.required_if' => '対応状況が「対応済み」または「非対応」の場合は:Attributeを入力してください。',
            'completed_at.prohibited_unless' => '対応状況が「対応済み」または「非対応」でない限り、:Attributeの入力は禁止されています。',
            'reason_id.required_if' => '対応状況が「非対応」の場合は:Attributeを選択してください。',
            'reason_id.prohibited_unless' => '対応状況が「非対応」でない限り、:Attributeの入力は禁止されています。',
        ];
    }
}
