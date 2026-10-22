<?php

declare(strict_types=1);

namespace App\Http\Requests\Employee\Qualification;

use App\Concerns\Qualification\QualificationValidationRules;
use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQualificationRequest extends FormRequest
{
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
     * Keep the qualification owned by the authenticated employee rather than
     * accepting a browser-supplied employee identifier during an update.
     */
    protected function prepareForValidation(): void
    {
        $user = $this->user();

        if (! $user instanceof User) {
            return;
        }

        $employee = $user->employee()->first();
        $qualification = $this->route('qualification');

        if (! $employee instanceof Employee) {
            return;
        }

        $this->merge([
            'employee_id' => $employee->id,
            'is_authenticated' => $qualification instanceof Qualification
                ? $qualification->is_authenticated
                : false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->updateRules();
    }
}
