<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Table(name: 'spatie_media')]
class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    /**
     * @use HasFactory<Factory>
     */
    use HasFactory;
}
