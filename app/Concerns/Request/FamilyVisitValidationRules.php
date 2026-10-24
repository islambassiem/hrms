<?php

namespace App\Concerns\Request;

use App\Enums\FamilyVisitStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait FamilyVisitValidationRules
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function createRules(): array
    {
        return [
            'employee_id' => $this->employee(),
            ...$this->baseRules(),
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function updateRules(): array
    {
        return [
            ...$this->baseRules(),
            'status' => ['nullable', Rule::enum(FamilyVisitStatusEnum::class)],
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    private function baseRules(): array
    {
        return [
            'number' => ['required', 'string', 'max:8'],
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
