<?php

declare(strict_types=1);

namespace App\Http\Requests\Employee\ShortLeave;

use App\Concerns\ShortLeave\ShortLeaveRequestValidationRules;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreShortLeaveRequest extends FormRequest
{
    use ShortLeaveRequestValidationRules;

    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && $user->employee()->exists();
    }

    protected function prepareForValidation(): void
    {
        $user = $this->user();

        if (! $user instanceof User) {
            return;
        }

        $employee = $user->employee;

        if (! $employee instanceof Employee) {
            return;
        }

        $this->merge([
            'employee_id' => $employee->id,
            'status' => WorkflowActionEnum::PENDING->value,
            ...$this->normalizedTimeValues(),
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function normalizedTimeValues(): array
    {
        return [
            'short_leave_from' => $this->normalizeTime('short_leave_from'),
            'short_leave_to' => $this->normalizeTime('short_leave_to'),
        ];
    }

    private function normalizeTime(string $field): string
    {
        $value = $this->input($field);

        if (! is_string($value)) {
            return '';
        }

        return preg_match('/^\d{2}:\d{2}$/', $value) === 1
            ? $value.':00'
            : $value;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->createRules();
    }
}
