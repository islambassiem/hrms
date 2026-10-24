<?php

namespace App\Concerns\Request;

use App\Enums\LetterStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait LetterValidationRules
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
            'status' => ['nullable', Rule::enum(LetterStatusEnum::class)],
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function baseRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'include_salary' => ['required', 'boolean'],
            'attested' => ['required', 'boolean'],
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
