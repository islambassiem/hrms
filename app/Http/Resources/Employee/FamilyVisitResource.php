<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Models\Request\FamilyVisit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FamilyVisit
 */
class FamilyVisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var FamilyVisit $visit */
        $visit = $this->resource;

        return [
            'id' => $visit->id,
            'employee' => [
                'id' => $visit->employee?->id,
                'employee_code' => $visit->employee?->employee_code,
                'name' => $visit->employee?->name,

            ],
            'number' => $visit->number,
            'status' => $visit->status->value,
        ];
    }
}
