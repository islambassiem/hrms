<?php

namespace App\Http\Requests\Employee\Qualification;

use App\Concerns\AttachmentValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class QualificationAttachmentRequest extends FormRequest
{
    use AttachmentValidationRules;

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->attachmentRules();
    }
}
