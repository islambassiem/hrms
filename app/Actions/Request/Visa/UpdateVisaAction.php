<?php

namespace App\Actions\Request\Visa;

use App\Concerns\Request\VisaValidationRules;
use App\Data\Request\VisaData;
use App\Enums\VisaStatusEnum;
use App\Exceptions\CannotUpdateRecord;
use App\Models\Request\Visa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateVisaAction
{
    use VisaValidationRules;

    public function handle(Visa $visa, VisaData $data): Visa
    {
        if ($visa->status === VisaStatusEnum::ISSUED) {
            throw new CannotUpdateRecord(
                __('Cannot update the visa after issuing')
            );
        }

        Validator::make(
            $data->toArray(),
            $this->updateRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($visa, $data, $currentUserId): Visa {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $visa->updated_by,
            ];

            $visa->update($payload);

            return $visa->refresh();
        });
    }
}
