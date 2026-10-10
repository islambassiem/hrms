<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Actions\AttachMediaAction;
use App\Concerns\Leave\LeaveRequestValidationRules;
use App\Data\Leave\LeaveRequestData;
use App\Models\Leave\LeaveRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/** Creates leave requests. */
final class LeaveRequestCreateAction
{
    use LeaveRequestValidationRules;

    /** @param LeaveRequestData $data The data to persist.
     * @param  UploadedFile|array<UploadedFile>|null  $attachments
     * @return LeaveRequest The created request.
     *
     * @throws ValidationException
     * */
    public function handle(
        LeaveRequestData $data,
        UploadedFile|array|null $attachments = null,
    ): LeaveRequest {
        Validator::make($data->toArray(), $this->createRules())->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        $created = DB::transaction(function () use ($data, $currentUserId): LeaveRequest {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'no_of_days' => $this->days($data),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var LeaveRequest $leaveRequest */
            $leaveRequest = LeaveRequest::query()->create($payload);

            return $leaveRequest;
        });

        if ($attachments !== null) {
            resolve(AttachMediaAction::class)->handle($created, $attachments);
        }

        return $created;

    }

    private function days(LeaveRequestData $data): int
    {
        return (int) $data->start_date->diffInDays($data->end_date) + 1;
    }
}
