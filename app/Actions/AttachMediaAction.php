<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use UnexpectedValueException;

final class AttachMediaAction
{
    /**
     * @param  UploadedFile|array<UploadedFile>  $files
     * @return Media|Collection<int, Media>
     */
    public function handle(
        HasMedia&Model $model,
        UploadedFile|array $files,
        string $collection = 'default',
    ): Media|Collection {

        if (\is_array($files) && $files === []) {
            /** @var Collection<int, Media> $media */
            $media = collect();

            return $media;
        }

        if ($files instanceof UploadedFile) {
            return $this->attach($model, $files, $collection);
        }

        return collect($files)->map(
            fn (UploadedFile $file): Media => $this->attach(
                $model,
                $file,
                $collection,
            ),
        );
    }

    private function attach(
        HasMedia&Model $model,
        UploadedFile $file,
        string $collection,
    ): Media {
        $media = $model
            ->addMedia($file)
            ->toMediaCollection($collection);

        throw_unless($media instanceof Media, UnexpectedValueException::class, 'Media Library returned an unexpected media model.');

        return $media;
    }
}
