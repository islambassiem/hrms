<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Media as CustomMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class SpatiePathGenerator implements PathGenerator
{
    /**
     * @param  CustomMedia  $media
     */
    public function getPath(BaseMedia $media): string
    {
        return "{$media->uuid}/";
    }

    /**
     * @param  CustomMedia  $media
     */
    public function getPathForConversions(BaseMedia $media): string
    {
        return "{$media->uuid}/conversions/";
    }

    /**
     * @param  CustomMedia  $media
     */
    public function getPathForResponsiveImages(BaseMedia $media): string
    {
        return "{$media->uuid}/responsive-images/";
    }
}
