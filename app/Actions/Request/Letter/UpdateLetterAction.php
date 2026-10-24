<?php

namespace App\Actions\Request\Letter;

use App\Concerns\Request\LetterValidationRules;
use App\Data\Request\Letter\LetterData;
use App\Enums\LetterStatusEnum;
use App\Exceptions\CannotUpdateRecord;
use App\Models\Request\Letter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateLetterAction
{
    use LetterValidationRules;

    public function handle(Letter $letter, LetterData $data): Letter
    {
        if ($letter->status === LetterStatusEnum::DONE) {
            throw new CannotUpdateRecord(
                __('Cannot update the letter after issuing')
            );
        }

        Validator::make(
            $data->toArray(),
            $this->updateRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($letter, $data, $currentUserId): Letter {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $letter->updated_by,
            ];

            $letter->update($payload);

            return $letter->refresh();
        });
    }
}
