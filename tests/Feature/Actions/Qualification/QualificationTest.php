<?php

use App\Actions\Qualification\QualificationCreateAction;
use App\Actions\Qualification\QualificationDeleteAction;
use App\Actions\Qualification\QualificationUpdateAction;
use App\Data\Qualification\QualificationData;
use App\Exceptions\CannotDeleteRecord;
use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('creates a qualification', function (): void {
    Storage::fake(config('media-library.disk_name'));
    $data = QualificationData::from(Qualification::factory()->make());
    $qualification = resolve(QualificationCreateAction::class)->handle($data);

    expect($qualification)->toBeInstanceOf(Qualification::class);
    $this->assertDatabaseHas('qualifications', $qualification->getAttributes());
    $media = $qualification->getMedia();
    expect($media)->toHaveCount(0);
});

it('creates a qualification with an attachment', function (): void {
    Storage::fake(config('media-library.disk_name'));
    $data = QualificationData::from(Qualification::factory()->make());
    $attachment = UploadedFile::fake()->create(
        'qualification.pdf',
        100,
        'application/pdf',
    );
    $qualification = resolve(QualificationCreateAction::class)->handle($data, $attachment);

    expect($qualification)->toBeInstanceOf(Qualification::class);
    $this->assertDatabaseHas('qualifications', $qualification->getAttributes());

    $media = $qualification->getMedia();

    expect($media)->toHaveCount(1)
        ->and($media->first()->model_id)->toBe($qualification->getKey());
});

it('creates a qualification with multiple attachment', function (): void {
    Storage::fake(config('media-library.disk_name'));
    $data = QualificationData::from(Qualification::factory()->make());

    $attachments = [
        UploadedFile::fake()->create('certificate.pdf', 100, 'application/pdf'),
        UploadedFile::fake()->create('supporting-document.pdf', 150, 'application/pdf'),
    ];
    $qualification = resolve(QualificationCreateAction::class)->handle($data, $attachments);

    expect($qualification)->toBeInstanceOf(Qualification::class);
    $this->assertDatabaseHas('qualifications', $qualification->getAttributes());

    $media = $qualification->getMedia();

    expect($media)->toHaveCount(2)
        ->and($media->first()->model_id)->toBe($qualification->getKey());
});

test('action fails when required fields are missing', function (): void {
    $data = QualificationData::from([]);

    expectValidationError(
        fn () => resolve(QualificationCreateAction::class)->handle($data),
        ['employee_id', 'major_id'],
    );
});

test('action fails when :dataset', function (array $overrides, array $fields): void {
    expectValidationError(
        fn () => resolve(QualificationCreateAction::class)->handle(
            QualificationData::from(
                Qualification::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Qualification Dataset');

it('updates a qualification', function (): void {
    $qualification = Qualification::factory()->create();
    $data = QualificationData::from(Qualification::factory()->make());
    $updatedQualification = resolve(QualificationUpdateAction::class)
        ->handle($qualification, $data);

    expect($updatedQualification->major_id)->toBe($data->major_id);
    $this->assertDatabaseHas('qualifications', $updatedQualification->getAttributes());
});

it('fails to update when :dataset', function (array $overrides, array $fields): void {
    $qualification = Qualification::factory()->create();
    expectValidationError(
        fn () => resolve(QualificationUpdateAction::class)->handle(
            $qualification,
            QualificationData::from(
                Qualification::factory()->make($overrides)
            )
        ), $fields
    );
})->with('Qualification Dataset');

it('deletes a qualification if there are many', function (): void {
    $employee = Employee::factory()->create();
    $qualifications = Qualification::factory(2)->create([
        'employee_id' => $employee->id,
    ]);
    $toBeDeleted = $qualifications->random();

    resolve(QualificationDeleteAction::class)->handle($toBeDeleted);

    $this->assertDatabaseMissing($toBeDeleted);

});

it('fails to delete only qualification', function (): void {

    $qualification = Qualification::factory()->create();

    expect(
        fn () => resolve(QualificationDeleteAction::class)->handle($qualification)
    )->toThrow(CannotDeleteRecord::class);

});

dataset('Qualification Dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('major_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('minor_id')
        ->notInteger()
        ->build(),

    ...invalid('educational_sublevel_id')
        ->notInteger()
        ->build(),

    ...invalid('included_specialty_id')
        ->notInteger()
        ->build(),

    ...invalid('institution_name')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('college_name')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('scientific_degree_id')
        ->notInteger()
        ->build(),

    ...invalid('graduation_date')
        ->build(),

    ...invalid('graduation_country_id')
        ->notInteger()
        ->build(),

    ...invalid('is_last_qualification')
        ->notBoolean()
        ->build(),

    ...invalid('rating_id')
        ->notInteger()
        ->build(),

    ...invalid('gpa')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('gpa_type_id')
        ->notInteger()
        ->build(),

    ...invalid('study_type_id')
        ->notInteger()
        ->build(),

    ...invalid('city')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('is_authenticated')
        ->notBoolean()
        ->build(),
]);
