<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Models\Request\Visa;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Visa
 */
class VisaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Visa $visa */
        $visa = $this->resource;

        return [
            'id' => $visa->id,
            'employee' => [
                'employee_code' => $visa->employee?->employee_code,
                'employee_name' => $visa->employee?->name,
            ],
            'start_date' => CarbonImmutable::parse($visa->start_date)->toDateString(),
            'end_date' => CarbonImmutable::parse($visa->end_date)->toDateString(),
            'for_year' => $visa->for_year,
            'status' => $visa->status->value,
            'payment' => $visa->payment->value,
            'payer' => $visa->payer->value,
        ];
    }
}
