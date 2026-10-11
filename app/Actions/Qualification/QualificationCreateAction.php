<?php

namespace App\Actions\Qualification;

use App\Actions\AttachMediaAction;
use App\Concerns\Qualification\QualificationValidationRules;
use App\Data\Qualification\QualificationData;
use App\Models\Qualifications\Qualification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QualificationCreateAction
{
    use QualificationValidationRules;

    /**
     * Summary of handle
     *
     * @param  UploadedFile|array<UploadedFile>|null  $attachments
     */
    public function handle(
        QualificationData $data,
        UploadedFile|array|null $attachments = null,
    ): Qualification {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        $created = DB::transaction(function () use ($data, $currentUserId): Qualification {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var Qualification $qualification */
            $qualification = Qualification::query()->create($payload);

            return $qualification;
        });

        if ($attachments !== null) {
            resolve(AttachMediaAction::class)->handle($created, $attachments);
        }

        return $created;
    }
}
