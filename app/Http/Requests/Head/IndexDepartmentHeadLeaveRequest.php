<?php

declare(strict_types=1);

namespace App\Http\Requests\Head;

use App\Enums\WorkflowActionEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class IndexDepartmentHeadLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && $user->can('view-head-page');
    }

    /** @return array<string, array<mixed>|string> */
    public function rules(): array
    {
        return [
            'employee_id' => ['nullable', 'integer', Rule::exists('employees', 'id')],
            'leave_type_id' => ['nullable', 'integer', Rule::exists('lookup_leave_types', 'id')],
            'status' => ['nullable', Rule::enum(WorkflowActionEnum::class)],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date'],
        ];
    }
}
