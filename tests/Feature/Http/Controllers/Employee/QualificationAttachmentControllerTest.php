<?php

declare(strict_types=1);

use App\Actions\AttachMediaAction;
use App\Models\Employee\Employee;
use App\Models\Media;
use App\Models\Qualifications\Qualification;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake(config('media-library.disk_name'));
});

test('employee can append multiple attachments to their qualification', function (): void {
    $employee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->post(route('qualifications.attachments.store', $qualification), [
            'attachments' => [
                UploadedFile::fake()->create(
                    'degree-certificate.pdf',
                    128,
                    'application/pdf',
                ),
                UploadedFile::fake()->create(
                    'transcript.png',
                    128,
                    'image/png',
                ),
            ],
        ])
        ->assertRedirectBack()
        ->assertSessionHas('success', __('Attachment uploaded successfully'));

    $media = $qualification->fresh()->getMedia();

    expect($media)->toHaveCount(2)
        ->and($media->pluck('file_name')->all())
        ->toEqualCanonicalizing([
            'degree-certificate.pdf',
            'transcript.png',
        ]);
});

test('employee cannot append attachments to another employee qualification', function (): void {
    $employee = Employee::factory()->create();
    $otherQualification = Qualification::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->post(route('qualifications.attachments.store', $otherQualification), [
            'attachments' => [
                UploadedFile::fake()->create(
                    'degree-certificate.pdf',
                    128,
                    'application/pdf',
                ),
            ],
        ])
        ->assertForbidden();

    expect($otherQualification->fresh()->getMedia())->toHaveCount(0);
});

test('user without an employee record cannot append qualification attachments', function (): void {
    $user = User::factory()->create();
    $qualification = Qualification::factory()->create();

    $this->actingAs($user)
        ->post(route('qualifications.attachments.store', $qualification), [
            'attachments' => [
                UploadedFile::fake()->create(
                    'degree-certificate.pdf',
                    128,
                    'application/pdf',
                ),
            ],
        ])
        ->assertForbidden();

    expect($qualification->fresh()->getMedia())->toHaveCount(0);
});

test('attachment append validates each uploaded file', function (): void {
    $employee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->from(route('qualifications.edit', $qualification))
        ->post(route('qualifications.attachments.store', $qualification), [
            'attachments' => [
                UploadedFile::fake()->create(
                    'qualification-notes.txt',
                    128,
                    'text/plain',
                ),
            ],
        ])
        ->assertRedirect(route('qualifications.edit', $qualification))
        ->assertSessionHasErrors('attachments.0');

    expect($qualification->fresh()->getMedia())->toHaveCount(0);
});

test('attachment append validates the maximum attachment count', function (): void {
    $employee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->from(route('qualifications.edit', $qualification))
        ->post(route('qualifications.attachments.store', $qualification), [
            'attachments' => array_map(
                fn (int $number): UploadedFile => UploadedFile::fake()->create(
                    "certificate-{$number}.pdf",
                    128,
                    'application/pdf',
                ),
                range(1, 6),
            ),
        ])
        ->assertRedirect(route('qualifications.edit', $qualification))
        ->assertSessionHasErrors('attachments');

    expect($qualification->fresh()->getMedia())->toHaveCount(0);
});

test('attachment append validates each attachment size', function (): void {
    $employee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->from(route('qualifications.edit', $qualification))
        ->post(route('qualifications.attachments.store', $qualification), [
            'attachments' => [
                UploadedFile::fake()->create(
                    'large-degree-certificate.pdf',
                    3 * 1024 + 1,
                    'application/pdf',
                ),
            ],
        ])
        ->assertRedirect(route('qualifications.edit', $qualification))
        ->assertSessionHasErrors('attachments.0');

    expect($qualification->fresh()->getMedia())->toHaveCount(0);
});

test('employee can remove media belonging to their qualification', function (): void {
    $employee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $user = User::query()->findOrFail($employee->user_id);
    resolve(AttachMediaAction::class)->handle(
        $qualification,
        UploadedFile::fake()->create(
            'degree-certificate.pdf',
            128,
            'application/pdf',
        ),
    );
    $media = $qualification->getFirstMedia();

    expect($media)->toBeInstanceOf(Media::class);

    $this->actingAs($user)
        ->delete(route('qualifications.attachments.destroy', [
            'qualification' => $qualification,
            'media' => $media,
        ]))
        ->assertRedirectBack()
        ->assertSessionHas('success', __('Attachment deleted successfully'));

    expect(Media::query()->find($media->id))->toBeNull();
});

test('employee cannot remove a different qualification media through their qualification route', function (): void {
    $employee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $otherQualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $user = User::query()->findOrFail($employee->user_id);
    resolve(AttachMediaAction::class)->handle(
        $otherQualification,
        UploadedFile::fake()->create(
            'other-degree-certificate.pdf',
            128,
            'application/pdf',
        ),
    );
    $media = $otherQualification->getFirstMedia();

    expect($media)->toBeInstanceOf(Media::class);

    $this->actingAs($user)
        ->delete(route('qualifications.attachments.destroy', [
            'qualification' => $qualification,
            'media' => $media,
        ]))
        ->assertNotFound();

    expect(Media::query()->find($media->id))->toBeInstanceOf(Media::class);
});

test('employee cannot remove another employee qualification media', function (): void {
    $employee = Employee::factory()->create();
    $otherQualification = Qualification::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);
    resolve(AttachMediaAction::class)->handle(
        $otherQualification,
        UploadedFile::fake()->create(
            'other-degree-certificate.pdf',
            128,
            'application/pdf',
        ),
    );
    $media = $otherQualification->getFirstMedia();

    expect($media)->toBeInstanceOf(Media::class);

    $this->actingAs($user)
        ->delete(route('qualifications.attachments.destroy', [
            'qualification' => $otherQualification,
            'media' => $media,
        ]))
        ->assertForbidden();

    expect(Media::query()->find($media->id))->toBeInstanceOf(Media::class);
});
