<?php

namespace App\Actions\Request\Letter;

use App\Concerns\Request\Letter\LetterValidationRules;
use App\Data\Request\Letter\LetterData;
use App\Enums\LetterStatusEnum;
use App\Models\Request\Letter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateLetterAction
{
    use LetterValidationRules;

    public function handle(LetterData $data): Letter
    {
        Validator::make(
            $data->toArray(),
            $this->createRules()
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): Letter {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'status' => LetterStatusEnum::PENDING->value,
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            return Letter::query()->create($payload);
        });
    }
}
