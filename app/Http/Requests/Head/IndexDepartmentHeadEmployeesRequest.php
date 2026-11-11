<?php

declare(strict_types=1);

namespace App\Http\Requests\Head;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class IndexDepartmentHeadEmployeesRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User && $user->can(PermissionEnum::HEAD_PAGE->value);
    }

    /** @return array<string, array<mixed>|string> */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'gender_id' => [
                'nullable',
                'integer',
                Rule::exists('lookup_genders', 'id')
                    ->whereIn('name_en', ['Male', 'Female']),
            ],
        ];
    }
}
