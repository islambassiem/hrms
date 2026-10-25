<?php

declare(strict_types=1);

namespace App\Http\Requests\Employee\Request\FamilyVisit;

use App\Concerns\Request\FamilyVisitValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyVisitRequest extends FormRequest
{
    use FamilyVisitValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->baseRules();
    }
}
