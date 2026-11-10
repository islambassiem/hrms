<?php

use App\Enums\PermissionEnum;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Lookup\Department;
use App\Models\Lookup\Gender;
use App\Models\Lookup\JobTitle;
use App\Models\Lookup\ScientificDegree;
use App\Models\Qualifications\Qualification;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;

beforeEach(function (): void {
    $this->withoutVite();
});

test('guests are redirected from the Department Head employee directory', function (): void {
    $this->get(route('head.employees.index'))
        ->assertRedirect(route('login'));
});

test('users without Head permission cannot view the employee directory', function (): void {
    $employee = Employee::factory()->create();
    $user = User::query()->findOrFail($employee->user_id);

    $this->actingAs($user)
        ->get(route('head.employees.index'))
        ->assertForbidden();
});

test('department heads receive only active direct reports with the directory fields', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $gender = Gender::factory()->create([
        'name_en' => 'Female',
        'name_ar' => 'أنثى',
    ]);
    Gender::factory()->create([
        'name_en' => 'Not a gender option',
        'name_ar' => 'خيار غير صالح',
    ]);
    $degree = ScientificDegree::factory()->create([
        'name_en' => 'Bachelor',
        'name_ar' => 'بكالوريوس',
    ]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'employee_code' => '500101',
        'gender_id' => $gender->id,
        'image' => 'employees/500101.png',
        'first_name_en' => 'Sara',
        'middle_name_en' => null,
        'third_name_en' => null,
        'last_name_en' => 'Employee',
    ]);
    $subordinate->user()->update(['email' => 'sara.employee@college.test']);
    Qualification::factory()->create([
        'employee_id' => $subordinate->id,
        'scientific_degree_id' => $degree->id,
        'graduation_date' => '2022-06-01',
        'is_last_qualification' => true,
    ]);
    Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => false,
    ]);
    Employee::factory()->create(['is_active' => true]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/employees/index', false)
            ->where('filters.search', null)
            ->where('filters.genderId', null)
            ->has('genders', 1)
            ->where('genders.0.id', $gender->id)
            ->where('genders.0.name', 'Female')
            ->has('employees.data', 1)
            ->where('employees.data.0.id', $subordinate->id)
            ->where('employees.data.0.employeeCode', '500101')
            ->where('employees.data.0.name', 'Sara Employee')
            ->where('employees.data.0.image', 'employees/500101.png')
            ->where('employees.data.0.gender.name', 'Female')
            ->where('employees.data.0.officialEmail', 'sara.employee@college.test')
            ->where('employees.data.0.latestQualification.scientificDegree', 'Bachelor')
            ->where('employees.data.0.latestQualification.graduationDate', '2022-06-01')
            ->where('employees.meta.total', 1),
        );
});

test('department heads can search and filter their active direct reports', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $female = Gender::factory()->create([
        'name_en' => 'Female',
        'name_ar' => 'أنثى',
    ]);
    $male = Gender::factory()->create([
        'name_en' => 'Male',
        'name_ar' => 'ذكر',
    ]);
    $matchingEmployee = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'gender_id' => $female->id,
        'first_name_en' => 'Mary',
        'middle_name_en' => null,
        'third_name_en' => null,
        'last_name_en' => 'Jane',
    ]);
    $matchingEmployee->user()->update(['email' => 'mary.jane@college.test']);
    Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'gender_id' => $male->id,
        'first_name_en' => 'Mary',
        'middle_name_en' => null,
        'third_name_en' => null,
        'last_name_en' => 'Other',
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.index', [
            'search' => 'mary.jane@college.test',
            'gender_id' => $female->id,
        ]))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/employees/index', false)
            ->where('filters.search', 'mary.jane@college.test')
            ->where('filters.genderId', $female->id)
            ->has('employees.data', 1)
            ->where('employees.data.0.id', $matchingEmployee->id)
            ->where('employees.links.next', null),
        );
});

test('a department head without an Employee profile cannot view the employee directory', function (): void {
    $user = User::factory()->create();
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.index'))
        ->assertForbidden();
});

test('the employee directory rejects an unknown gender filter', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.index', ['gender_id' => 999999]))
        ->assertSessionHasErrors('gender_id');
});

test('the employee directory rejects a lookup value outside the configured gender options', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $unsupportedGender = Gender::factory()->create([
        'name_en' => 'Not a gender option',
        'name_ar' => 'خيار غير صالح',
    ]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.index', ['gender_id' => $unsupportedGender->id]))
        ->assertSessionHasErrors('gender_id');
});

test('a department head with no active direct reports sees an empty directory contract', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => false,
    ]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/employees/index', false)
            ->has('employees.data', 0)
            ->where('employees.meta.total', 0),
        );
});

test('department heads can view scoped employee details with position and qualification records', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $department = Department::factory()->create([
        'name_en' => 'Academic Affairs',
        'name_ar' => 'الشؤون الأكاديمية',
    ]);
    $gender = Gender::factory()->create([
        'name_en' => 'Female',
        'name_ar' => 'أنثى',
    ]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
        'department_id' => $department->id,
        'gender_id' => $gender->id,
        'employee_code' => '500201',
        'first_name_en' => 'Lina',
        'middle_name_en' => null,
        'third_name_en' => null,
        'last_name_en' => 'Hassan',
        'joining_date' => '2020-09-01',
    ]);
    $subordinate->user()->update(['email' => 'lina.hassan@college.test']);

    $jobTitle = JobTitle::factory()->create([
        'name_en' => 'Lecturer',
        'name_ar' => 'محاضر',
    ]);
    EmployeeJobTitle::factory()->create([
        'employee_id' => $subordinate->id,
        'job_title_id' => $jobTitle->id,
        'start_date' => '2023-08-01',
        'end_date' => null,
    ]);
    $qualification = Qualification::factory()->create([
        'employee_id' => $subordinate->id,
        'institution_name' => 'Example University',
        'college_name' => 'Science',
        'graduation_date' => '2019-06-01',
        'is_last_qualification' => true,
    ]);

    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.show', $subordinate->id))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/employees/show', false)
            ->where('employee.id', $subordinate->id)
            ->where('employee.employeeCode', '500201')
            ->where('employee.name', 'Lina Hassan')
            ->where('employee.gender', 'Female')
            ->where('employee.officialEmail', 'lina.hassan@college.test')
            ->where('employee.department', 'Academic Affairs')
            ->where('employee.joiningDate', '2020-09-01')
            ->where('employee.currentPosition.title', 'Lecturer')
            ->where('employee.currentPosition.startDate', '2023-08-01')
            ->where('qualifications.0.id', $qualification->id)
            ->where('qualifications.0.institutionName', 'Example University')
            ->where('qualifications.0.collegeName', 'Science')
            ->where('qualifications.0.graduationDate', '2019-06-01')
            ->has('qualifications.0.attachments', 0)
            ->missing('employee.academicRank')
            ->missing('qualifications.0.attachments.0.url'),
        );
});

test('department heads cannot view inactive or unrelated employee details', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $inactiveSubordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => false,
    ]);
    $unrelatedEmployee = Employee::factory()->create(['is_active' => true]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.show', $inactiveSubordinate->id))
        ->assertNotFound();

    $this->get(route('head.employees.show', $unrelatedEmployee->id))
        ->assertNotFound();
});

test('users without Head permission cannot view employee details', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $user = User::query()->findOrFail($departmentHead->user_id);

    $this->actingAs($user)
        ->get(route('head.employees.show', $subordinate->id))
        ->assertForbidden();
});

test('employee details return truthful empty qualification and position values', function (): void {
    $departmentHead = Employee::factory()->create(['is_active' => true]);
    $subordinate = Employee::factory()->create([
        'head_id' => $departmentHead->id,
        'is_active' => true,
    ]);
    $user = User::query()->findOrFail($departmentHead->user_id);
    $user->givePermissionTo(Permission::findOrCreate(PermissionEnum::HEAD_PAGE->value, 'web'));

    $this->actingAs($user)
        ->get(route('head.employees.show', $subordinate->id))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('head/employees/show', false)
            ->where('employee.currentPosition', null)
            ->has('qualifications', 0),
        );
});
