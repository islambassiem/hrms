<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Employee
 */
final class DepartmentHeadEmployeeOptionResource extends JsonResource
{
    /** @return array{id: int, name: string, employeeCode: string} */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'employeeCode' => $this->employee_code,
        ];
    }
}
