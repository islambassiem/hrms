<?php

declare(strict_types=1);

namespace App\Http\Requests\Employee\Qualification;

use App\Concerns\AttachmentValidationRules;
use App\Concerns\Qualification\QualificationValidationRules;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreQualificationRequest extends FormRequest
{
    use AttachmentValidationRules;
    use QualificationValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && $user->employee()->exists();
    }

    /**
     * Resolve the employee from the authenticated account rather than trusting
     * a browser-supplied employee identifier.
     */
    protected function prepareForValidation(): void
    {
        $user = $this->user();

        if (! $user instanceof User) {
            return;
        }

        $employee = $user->employee()->first();

        if (! $employee instanceof Employee) {
            return;
        }

        $this->merge([
            'employee_id' => $employee->id,
            'is_authenticated' => false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $attachmentRules = $this->attachmentRules();

        $attachmentRules['attachments'] = [
            'sometimes',
            'array',
            'min:1',
            'max:5',
        ];

        return [
            ...$this->createRules(),
            ...$attachmentRules,
        ];
    }
}
