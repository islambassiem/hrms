<?php

namespace App\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\File;

trait AttachmentValidationRules
{
    /** @var array<int, string> */
    protected array $attachmentTypes = [
        'pdf',
        'png',
        'jpeg',
        'jpg',
    ];

    protected int $attachmentMaxSize = 3 * 1024;

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function attachmentRules(): array
    {
        return [
            'attachments' => ['required', 'array', 'min:1', 'max:5'],
            'attachments.*' => [
                'required',
                File::types($this->attachmentTypes)
                    ->max($this->attachmentMaxSize),
            ],
        ];
    }
}
