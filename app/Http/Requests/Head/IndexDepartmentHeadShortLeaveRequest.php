<?php

declare(strict_types=1);

namespace App\Http\Requests\Head;

use App\Enums\WorkflowActionEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class IndexDepartmentHeadShortLeaveRequest extends FormRequest
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
            'short_leave_type_id' => ['nullable', 'integer', Rule::exists('lookup_short_leave_types', 'id')],
            'status' => ['nullable', Rule::enum(WorkflowActionEnum::class)],
            'from_date' => ['nullable', 'date_format:Y-m-d'],
            'to_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:from_date'],
        ];
    }
}
