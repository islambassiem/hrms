<?php

namespace App\Concerns\Request;

use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
use App\Enums\VisaStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait VisaValidationRules
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
        ];
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    private function baseRules(): array
    {
        return [
            'start_date' => ['required', Rule::date()],
            'end_date' => ['required', Rule::date()->after('start_date')],
            'for_year' => ['required', 'integer'],
            'status' => ['required', Rule::enum(VisaStatusEnum::class)],
            'payment' => ['required', Rule::enum(VisaPaymentEnum::class)],
            'payer' => ['required', Rule::enum(VisaPayerEnum::class)],
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
