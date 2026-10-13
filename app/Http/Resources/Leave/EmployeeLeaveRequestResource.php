<?php

declare(strict_types=1);

namespace App\Http\Resources\Leave;

use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin LeaveRequest
 */
final class EmployeeLeaveRequestResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var CarbonImmutable $startDate */
        $startDate = $this->start_date;

        /** @var CarbonImmutable $endDate */
        $endDate = $this->end_date;

        /** @var CarbonInterface $submittedDate */
        $submittedDate = $this->created_at;

        $leaveType = $this->relationLoaded('leaveType')
            ? $this->getRelation('leaveType')
            : null;

        return [
            'id' => $this->id,
            'leaveType' => $leaveType instanceof LeaveType ? [
                'id' => $leaveType->id,
                'name' => $leaveType->name,
            ] : null,
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'durationDays' => (int) $this->no_of_days,
            'status' => $this->status,
            'submittedDate' => $submittedDate->toDateString(),
            'reason' => $this->reason,
            'attachments' => $this->getMedia()->map(
                static fn (Media $media): array => [
                    'id' => $media->id,
                    'name' => $media->file_name,
                    'sizeBytes' => (int) $media->size,
                ],
            )->values()->all(),
            'approvalTimeline' => null,
            'canCancel' => false,
        ];
    }
}
