<?php

declare(strict_types=1);

namespace App\Http\Requests\Employee\Qualification;

use App\Concerns\AttachmentValidationRules;
use App\Models\Qualifications\Qualification;
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
        $qualification = $this->route('qualification');

        return $qualification instanceof Qualification
            && $this->user()?->can('update', $qualification) === true;
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
