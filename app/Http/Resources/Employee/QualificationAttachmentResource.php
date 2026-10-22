<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Media
 */
final class QualificationAttachmentResource extends JsonResource
{
    /**
     * @return array{id: int, name: string, size_bytes: int, mime_type: string|null}
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->file_name,
            'size_bytes' => (int) $this->size,
            'mime_type' => $this->mime_type,
        ];
    }
}
