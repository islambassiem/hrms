<?php

declare(strict_types=1);

namespace App\Http\Resources\Leave;

use App\Models\Lookup\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LeaveType
 */
final class LeaveTypeOptionResource extends JsonResource
{
    /**
     * @return array{id: int, label: string, description: string|null}
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->name,
            'description' => $this->description,
        ];
    }
}
