<?php

use App\Actions\Qualification\QualificationCreateAction;
use App\Actions\Qualification\QualificationUpdateAction;
use App\Data\Qualification\QualificationData;
use App\Models\Qualifications\Qualification;

it('creates a qualification', function (): void {
    $data = QualificationData::from(Qualification::factory()->make());
    $qualification = resolve(QualificationCreateAction::class)->handle($data);

    expect($qualification)->toBeInstanceOf(Qualification::class);
    $this->assertDatabaseHas('qualifications', $qualification->getAttributes());
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
