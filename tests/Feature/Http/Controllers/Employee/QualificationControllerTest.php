<?php

use App\Exceptions\CannotDeleteRecord;
use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('index page has no qualifications when employee does not have qualificaiton', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->get(route('qualifications.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/qualification/index')
            ->count('qualifications.data', 0)
            ->where('canCreate', false)
        );
});

test('index page shows employee qualificaitons', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    Qualification::factory(6)->create([
        'employee_id' => $employee->id,
    ]);
    Qualification::factory(5)->create();

    $this->actingAs($user);

    $this->get(route('qualifications.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/qualification/index')
            ->count('qualifications.data', 6)
            ->has('qualifications.data.0.gpa_type.id')
            ->where('canCreate', true)
        );
});

it('renders the form of qualification creation', function (): void {
    $user = User::factory()->create();
    Employee::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);
    $this->get(route('qualifications.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/qualification/create')
            ->has('props.countries')
            ->has('props.educational_sublevels')
            ->has('props.gpa_types')
            ->has('props.included_specializations')
            ->has('props.ratings')
            ->has('props.scientific_degrees')
            ->has('props.specialities')
            ->has('props.study_types')
        );
});

test('user without an employee profile cannot access the qualification creation form', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('qualifications.create'))
        ->assertForbidden();
});

it('stores a qualification record', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('qualifications.store'),
        Qualification::factory()->make([
            'employee_id' => $employee->id,
            'is_authenticated' => true,
        ])->toArray(),
    );

    $this->assertDatabaseHas('qualifications', [
        'employee_id' => $employee->id,
        'is_authenticated' => false,
    ]);

    $response->assertRedirectBack();
    $response->assertSessionHas('success', __('The qualification stored successfully'));
});

test('store derives the qualification employee from the authenticated user', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $otherEmployee = Employee::factory()->create();
    $qualification = Qualification::factory()->make([
        'employee_id' => $otherEmployee->id,
        'institution_name' => 'Authenticated Employee University',
    ]);

    $this->actingAs($user)
        ->post(route('qualifications.store'), $qualification->toArray())
        ->assertRedirectBack();

    $this->assertDatabaseHas('qualifications', [
        'employee_id' => $employee->id,
        'institution_name' => 'Authenticated Employee University',
    ]);

    $this->assertDatabaseMissing('qualifications', [
        'employee_id' => $otherEmployee->id,
        'institution_name' => 'Authenticated Employee University',
    ]);
});

test('store validates an invalid last qualification value before creating a record', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $qualification = Qualification::factory()->make([
        'employee_id' => $employee->id,
        'is_last_qualification' => false,
    ]);

    $this->actingAs($user)
        ->post(route('qualifications.store'), [
            ...$qualification->toArray(),
            'is_last_qualification' => ['not-a-boolean'],
        ])
        ->assertSessionHasErrors('is_last_qualification');
});

test('user without an employee profile cannot store a qualification', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('qualifications.store'))
        ->assertForbidden();
});

test('employee cannot view other qualifications', function (): void {
    $user = User::factory()->create();
    $qualification = Qualification::factory()->create();

    $this->actingAs($user);
    $this->get(route('qualifications.show', ['qualification' => $qualification->id]))
        ->assertForbidden();
});

test('employee can view his own qualifications', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
        'is_authenticated' => false,
    ]);

    $this->actingAs($user);
    $this->get(route('qualifications.show', ['qualification' => $qualification->id]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/qualification/show')
            ->where('qualification.id', $qualification->id)
            ->where('qualification.gpa_type.id', $qualification->gpa_type_id)
        );
});

test('employee can access edit form for his own qualificaiton', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
        'is_authenticated' => false,
    ]);

    $this->actingAs($user);
    $this->get(route('qualifications.edit', ['qualification' => $qualification->id]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('employee/qualification/edit')
            ->where('qualification.id', $qualification->id)
            ->has('props.countries')
            ->has('props.gpa_types')
        );
});

test('employee cannot access edit form for other qualificaiton', function (): void {
    $user = User::factory()->create();
    $qualification = Qualification::factory()->create();

    $this->actingAs($user);
    $this->get(route('qualifications.edit', ['qualification' => $qualification->id]))
        ->assertForbidden();
});

test('employee can update his own qualificaiton', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
        'is_authenticated' => false,
    ]);

    $this->actingAs($user);

    $newQualification = Qualification::factory()->make([
        'employee_id' => $employee->id,
        'is_authenticated' => true,
    ]);

    $this->put(route('qualifications.update', ['qualification' => $qualification->id]), $newQualification->toArray())
        ->assertRedirectBack()
        ->assertSessionHas('success', __('Qualification updated successfully'));

    $this->assertDatabaseHas('qualifications', [
        'id' => $qualification->id,
        'employee_id' => $employee->id,
        'institution_name' => $newQualification->institution_name,
        'college_name' => $newQualification->college_name,
        'major_id' => $newQualification->major_id,
        'is_authenticated' => false,
    ]);
});

test('employee cannot update other qualificaiton', function (): void {
    $user = User::factory()->create();
    $qualification = Qualification::factory()->create();

    $this->actingAs($user);

    $newQualification = Qualification::factory()->make();

    $this->put(route('qualifications.update', ['qualification' => $qualification->id]), $newQualification->toArray())
        ->assertForbidden();
});

test('update keeps a qualification assigned to the authenticated employee', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $otherEmployee = Employee::factory()->create();
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);
    $updatedQualification = Qualification::factory()->make([
        'employee_id' => $otherEmployee->id,
        'institution_name' => 'Employee-owned updated institution',
    ]);

    $this->actingAs($user)
        ->put(
            route('qualifications.update', ['qualification' => $qualification->id]),
            $updatedQualification->toArray(),
        )
        ->assertRedirectBack();

    $this->assertDatabaseHas('qualifications', [
        'id' => $qualification->id,
        'employee_id' => $employee->id,
        'institution_name' => 'Employee-owned updated institution',
    ]);
});

test('employee cannot delete other qualificaiton', function (): void {
    $user = User::factory()->create();
    $qualification = Qualification::factory()->create();

    $this->actingAs($user);

    $this->delete(route('qualifications.destroy', ['qualification' => $qualification->id]))
        ->assertForbidden();
});

test('employee can delete his own qualificaiton if only one qualification exists', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $qualifications = Qualification::factory(2)->create([
        'employee_id' => $employee->id,
    ]);

    $this->actingAs($user);

    $this->delete(route('qualifications.destroy', ['qualification' => $qualifications[0]->id]))
        ->assertRedirectBack()
        ->assertSessionHas('success', __('Qualification was deleted successfully'));

    $this->assertDatabaseMissing('qualifications', [
        'id' => $qualifications[0]->id,
    ]);

    $this->assertDatabaseHas('qualifications', [
        'id' => $qualifications[1]->id,
    ]);
});

test('employee cannot delete all qualifications', function (): void {
    $user = User::factory()->create();
    $employee = Employee::factory()->create([
        'user_id' => $user->id,
    ]);
    $qualification = Qualification::factory()->create([
        'employee_id' => $employee->id,
    ]);

    $this->actingAs($user);

    $this->withoutExceptionHandling();

    expect(fn () => $this->delete(
        route('qualifications.destroy', [
            'qualification' => $qualification->id,
        ])
    ))->toThrow(CannotDeleteRecord::class);

    $this->assertDatabaseHas('qualifications', [
        'id' => $qualification->id,
    ]);
});
