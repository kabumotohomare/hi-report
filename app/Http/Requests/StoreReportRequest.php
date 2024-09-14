<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            "category_id" => "required|exists:categories,id",
            "image" => "required|image",
            "latitude" => "required",
            "longitude" => "required",
            "detail" => "required",
            "email" => "nullable|email:rfc,dns",
            "contact" => "nullable",
            "reported_at" => "nullable|date",
            "status_id" => "sometimes|required|exists:statuses,id",
            "comment" => "nullable",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date|exclude_without:start_date|after_or_equal:start_date",
            "completed_at" => "nullable|required_if:status_id,4,5|prohibited_unless:status_id,4,5|date",
            "reason_id" => "nullable|required_if:status_id,5|prohibited_unless:status_id,5|exists:reasons,id",
        ];
    }
}
