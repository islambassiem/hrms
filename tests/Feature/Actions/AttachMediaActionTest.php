<?php

declare(strict_types=1);

use App\Actions\AttachMediaAction;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

beforeAll(function (): void {
    #[Unguarded]
    #[Table(name: 'media_test_models')]
    final class MediaTestModel extends Model implements HasMedia
    {
        use HasFactory;
        use HasFactory;
        use InteractsWithMedia;
    }
});

beforeEach(function (): void {
    Schema::create('media_test_models', function (Blueprint $table): void {
        $table->id();
        $table->timestamps();
    });

    Storage::fake(config('media-library.disk_name'));
});

it('attaches a single file and returns the custom media model', function (): void {
    $model = MediaTestModel::query()->create();
    $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
    $media = resolve(AttachMediaAction::class)->handle($model, $file);

    expect($media)
        ->toBeInstanceOf(Media::class)
        ->and($media->collection_name)->toBe('default')
        ->and($media->model_id)->toBe($model->getKey())
        ->and($media->model_type)->toBe($model->getMorphClass())
        ->and($media->exists)->toBeTrue();

    Storage::disk($media->disk)->assertExists($media->getPathRelativeToRoot());

    expect($media->getTable())->toBe('spatie_media');
});

it('attaches multiple files and returns a collection of custom media models', function (): void {
    $model = MediaTestModel::query()->create();

    $files = [
        UploadedFile::fake()->create('document-one.pdf', 100, 'application/pdf'),
        UploadedFile::fake()->create('document-two.pdf', 150, 'application/pdf'),
    ];

    $media = resolve(AttachMediaAction::class)->handle($model, $files, 'attachments');

    expect($media)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2);

    foreach ($media as $item) {
        expect($item)
            ->toBeInstanceOf(Media::class)
            ->and($item->collection_name)->toBe('attachments')
            ->and($item->model_id)->toBe($model->getKey())
            ->and($item->exists)->toBeTrue();

        Storage::disk($item->disk)->assertExists($item->getPathRelativeToRoot());
        expect($item->getTable())->toBe('spatie_media');
    }
});

it('returns an empty collection when given no files', function (): void {
    $model = MediaTestModel::query()->create();

    $media = resolve(AttachMediaAction::class)->handle($model, []);

    expect($media)
        ->toBeInstanceOf(Collection::class)
        ->toBeEmpty();

    expect($model->media()->count())->toBe(0);
});
