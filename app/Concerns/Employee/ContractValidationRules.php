<?php

namespace App\Concerns\Employee;

use App\Enums\ContractTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait ContractValidationRules
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'employee_id' => $this->employee(),
            'start_date' => ['required', Rule::date()],
            'duration' => ['required', 'integer'],
            'probation_period' => ['required', 'integer'],
            'notice_period' => ['required', 'integer'],
            'type' => ['required', Rule::enum(ContractTypeEnum::class)],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ];
    }

    /**
     * @return array<string|Exists>
     */
    private function employee(): array
    {
        return [
            'required',
            'integer',
            Rule::exists('employees', 'id'),
        ];
    }
}
