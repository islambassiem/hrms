<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Models\Lookup\ShortLeaveType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ShortLeaveType
 */
final class DepartmentHeadShortLeaveTypeOptionResource extends JsonResource
{
    /** @return array{id: int, name: string} */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
