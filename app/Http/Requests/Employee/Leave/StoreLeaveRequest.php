<?php

namespace App\Http\Requests\Employee\Leave;

use App\Concerns\Leave\LeaveRequestValidationRules;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreLeaveRequest extends FormRequest
{
    use LeaveRequestValidationRules;

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
            'status' => WorkflowActionEnum::PENDING->value,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...$this->createRules(),
            'attachments' => [
                'nullable',
                File::types(['pdf', 'png', 'jpeg', 'jpg'])
                    ->max(1024 * 3),
            ],
        ];
    }
}
