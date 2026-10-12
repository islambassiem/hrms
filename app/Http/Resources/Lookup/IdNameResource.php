<?php

declare(strict_types=1);

namespace App\Http\Resources\Lookup;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdNameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Model $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->getAttribute('id'),
            'name' => $resource->getAttribute('name'),
        ];
    }
}
