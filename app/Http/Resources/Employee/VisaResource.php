<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Models\Request\Visa;
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
            'start_date' => $visa->start_date,
            'end_date' => $visa->end_date,
            'status' => $visa->status,
            'payment' => $visa->payment,
            'payer' => $visa->payer,
        ];
    }
}
