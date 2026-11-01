<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ShortLeaveRequest
 */
final class ShortLeaveRequestResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ShortLeaveRequest $shortLeaveRequest */
        $shortLeaveRequest = $this->resource;
        $user = $request->user();

        return [
            'id' => $shortLeaveRequest->id,
            'shortLeaveType' => [
                'id' => $shortLeaveRequest->shortLeaveType?->id,
                'name' => $shortLeaveRequest->shortLeaveType?->name,
            ],
            'shortLeaveDate' => CarbonImmutable::parse(
                (string) $shortLeaveRequest->short_leave_date,
            )->toDateString(),
            'shortLeaveFrom' => CarbonImmutable::parse(
                (string) $shortLeaveRequest->short_leave_from,
            )->format('H:i'),
            'shortLeaveTo' => CarbonImmutable::parse(
                (string) $shortLeaveRequest->short_leave_to,
            )->format('H:i'),
            'status' => $shortLeaveRequest->status,
            'submittedDate' => $shortLeaveRequest->created_at?->toDateString(),
            'canEdit' => $user instanceof User
                && $user->can('update', $shortLeaveRequest),
            'canDelete' => $user instanceof User
                && $user->can('delete', $shortLeaveRequest),
        ];
    }
}
