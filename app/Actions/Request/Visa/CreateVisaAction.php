<?php

namespace App\Actions\Request\Visa;

use App\Concerns\Request\VisaValidationRules;
use App\Data\Request\VisaData;
use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
use App\Enums\VisaStatusEnum;
use App\Models\Request\Visa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateVisaAction
{
    use VisaValidationRules;

    public function handle(VisaData $data): Visa
    {
        Validator::make(
            $data->toArray(),
            $this->createRules()
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): Visa {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'status' => VisaStatusEnum::PENDING->value,
                'payment' => VisaPaymentEnum::PENDING->value,
                'payer' => $this->payer($data->employee_id, $data->for_year),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            return Visa::query()->create($payload);
        });
    }

    protected function payer(int $employee_id, int $for_year): string
    {
        $paid = Visa::query()
            ->where('employee_id', $employee_id)
            ->where('for_year', $for_year)
            ->where('status', VisaStatusEnum::ISSUED->value)
            ->where('payment', VisaPaymentEnum::PAID->value)
            ->where('payer', VisaPayerEnum::COMPANY->value)
            ->exists();

        if ($paid) {
            return VisaPayerEnum::EMPLOYEE->value;
        }

        return VisaPayerEnum::COMPANY->value;
    }
}
