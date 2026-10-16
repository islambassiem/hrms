<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Media;

class DeleteMediaAction
{
    /**
     * @param  Media|array<Media>  $media
     */
    public function handle(Media|array $media): void
    {
        if ($media instanceof Media) {
            $media->delete();

            return;
        }

        collect($media)->each(fn (Media $item) => $item->delete());
    }
}
