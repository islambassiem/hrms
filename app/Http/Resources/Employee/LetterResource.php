<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Models\Request\Letter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LetterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Letter $letter */
        $letter = $this->resource;

        return [
            'id' => $letter->id,
            'employee' => $this->whenLoaded('employee', fn (): array => [
                'employee_code' => $letter->employee?->employee_code,
                'name' => $letter->employee?->name,
            ]),
            'title' => $letter->title,
            'description' => $letter->description,
            'notes' => $letter->notes,
            'include_salary' => $letter->include_salary,
            'attested' => $letter->attested,
            'status' => $letter->status->value,
        ];
    }
}
