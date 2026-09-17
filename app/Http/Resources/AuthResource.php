<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class AuthResource extends JsonResource
{
    public static $wrap;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'employee_code' => $this->employee?->employee_code,
            'name_en' => $this->employee?->full_name_en,
            'name_ar' => $this->employee?->full_name_ar,
            'avatar' => $this->employee?->image,
            'permissions' => $this->getAllPermissions()->pluck('name')->toArray(),
        ];
    }
}
