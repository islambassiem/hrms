<?php

use App\Actions\DeleteMediaAction;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
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
        use InteractsWithMedia;
    }
});

beforeEach(function (): void {
    Schema::dropIfExists('media_test_models');

    Schema::create('media_test_models', function (Blueprint $table): void {
        $table->id();
        $table->timestamps();
    });

    Storage::fake(config('media-library.disk_name', 'public'));
});

it('deletes Spatie media from the database and filesystem', function (): void {
    $model = MediaTestModel::query()->create();
    $media = $model->addMedia(
        UploadedFile::fake()->create('document.pdf', 100, 'application/pdf')
    )
        ->toMediaCollection('default');
    $disk = Storage::disk($media->disk);

    $disk->assertExists($media->getPathRelativeToRoot());

    expect(Media::query()->find($media->id) !== null)->toBeTrue();
    expect(Media::query()->find($media->id))->toBeInstanceOf(Media::class);

    resolve(DeleteMediaAction::class)->handle($media);

    expect(Media::query()->find($media->id))->toBeNull();
    $disk->assertMissing($media->getPath());
});

it('can delete multiple Spatie media items at once', function (): void {
    $model = MediaTestModel::query()->create();

    $media1 = $model->addMedia(UploadedFile::fake()->image('img1.jpg'))->toMediaCollection('gallery');
    $media2 = $model->addMedia(UploadedFile::fake()->image('img2.jpg'))->toMediaCollection('gallery');

    $disk = Storage::disk($media1->disk);
    $path1 = $media1->getPathRelativeToRoot();
    $path2 = $media2->getPathRelativeToRoot();

    resolve(DeleteMediaAction::class)->handle([$media1, $media2]);

    expect(Media::query()->count())->toBe(0);
    $disk->assertMissing($path1);
    $disk->assertMissing($path2);
});
