<?php

namespace App\Http\Requests\Employee\Leave;

use App\Concerns\Leave\LeaveRequestValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreLeaveRequest extends FormRequest
{
    use LeaveRequestValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...$this->createRules(),
            'attachments' => [
                'nullable',
                File::types(['pdf', 'png', 'jpeg', 'jpg'])
                    ->max(1024 * 3),
            ],
        ];
    }
}
