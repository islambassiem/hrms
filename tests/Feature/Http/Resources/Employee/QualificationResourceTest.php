<?php

declare(strict_types=1);

use App\Actions\AttachMediaAction;
use App\Http\Resources\Employee\QualificationResource;
use App\Models\Media;
use App\Models\Qualifications\Qualification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('maps only safe metadata for qualification attachments', function (): void {
    Storage::fake(config('media-library.disk_name'));

    $qualification = Qualification::factory()->create();
    resolve(AttachMediaAction::class)->handle(
        $qualification,
        UploadedFile::fake()->create(
            'degree-certificate.pdf',
            128,
            'application/pdf',
        ),
    );

    $result = QualificationResource::make(
        $qualification->load('media'),
    )->resolve(request());

    $media = Media::query()->sole();

    expect($result['attachments'])->toBe([
        [
            'id' => $media->id,
            'name' => $media->file_name,
            'size_bytes' => (int) $media->size,
            'mime_type' => $media->mime_type,
        ],
    ]);
});
