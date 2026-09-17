<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Employees{
/**
 * @use UserStamp<Employee>
 * @property int $id
 * @property int|null $user_id
 * @property int|null $head_id
 * @property string $employee_code
 * @property string $first_name_ar
 * @property string|null $middle_name_ar
 * @property string|null $third_name_ar
 * @property string $last_name_ar
 * @property string|null $full_name_ar
 * @property string $first_name_en
 * @property string|null $middle_name_en
 * @property string|null $third_name_en
 * @property string $last_name_en
 * @property string|null $full_name_en
 * @property int|null $marital_status_id
 * @property int|null $religion_id
 * @property int|null $special_need_id
 * @property int $gender_id
 * @property int $category_id
 * @property int $department_id
 * @property int $nationality_id
 * @property int|null $place_of_birth_id
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $image
 * @property string|null $date_of_birth
 * @property string|null $joining_date
 * @property string|null $leaving_date
 * @property string|null $home_telephone_number
 * @property string|null $home_country_identity
 * @property string|null $blood_type
 * @property int $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Employees\EmployeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereBloodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereEmployeeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereFirstNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereFirstNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereFullNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereFullNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereHomeCountryIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereHomeTelephoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereJoiningDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereLastNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereLastNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereLeavingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereMaritalStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereMiddleNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereMiddleNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereNationalityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee wherePlaceOfBirthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereReligionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereSpecialNeedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereThirdNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereThirdNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee whereUserId($value)
 */
	class Employee extends \Eloquent {}
}

namespace App\Models\Employees{
/**
 * @property int $id
 * @property int $employee_id
 * @property string $short_address
 * @property string|null $building_number
 * @property string|null $street
 * @property string|null $secondary_number
 * @property string|null $district
 * @property string|null $postal_code
 * @property string|null $city
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Employees\EmployeeAddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereBuildingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereSecondaryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereShortAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeAddress whereUpdatedBy($value)
 */
	class EmployeeAddress extends \Eloquent {}
}

namespace App\Models\Employees{
/**
 * @property int $id
 * @property int $employee_id
 * @property string|null $name_en
 * @property string|null $name_ar
 * @property string $identification
 * @property int $gender_id
 * @property string $date_of_birth
 * @property int $relationship_id
 * @property int $has_insurance
 * @property int $ticket_ratio
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Employees\EmployeeDependentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereGenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereHasInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereIdentification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereTicketRatio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeDependent whereUpdatedBy($value)
 */
	class EmployeeDependent extends \Eloquent {}
}

namespace App\Models\Employees{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $identity_type_id
 * @property string $identity_number
 * @property string|null $place_of_issue
 * @property string|null $issue_date
 * @property string|null $expiry_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Employees\EmployeeIdentityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereIdentityNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereIdentityTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity wherePlaceOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeIdentity whereUpdatedBy($value)
 */
	class EmployeeIdentity extends \Eloquent {}
}

namespace App\Models\Employees{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $job_title_id
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Employees\EmployeeJobTitleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereJobTitleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeJobTitle whereUpdatedBy($value)
 */
	class EmployeeJobTitle extends \Eloquent {}
}

namespace App\Models\Employees{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $managerial_role_id
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Employees\EmployeeManagerialRoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereManagerialRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeManagerialRole whereUpdatedBy($value)
 */
	class EmployeeManagerialRole extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $leave_policy_id
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Leave\EmployeeLeavePolicyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereLeavePolicyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeLeavePolicy whereUpdatedBy($value)
 */
	class EmployeeLeavePolicy extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $employee_id
 * @property string $start_date
 * @property string|null $end_date
 * @property int $used_days
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\Leave\EmployeeSickLeaveCycleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSickLeaveCycle whereUsedDays($value)
 */
	class EmployeeSickLeaveCycle extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property numeric $available_days
 * @property numeric $accrued_days
 * @property numeric $used_days
 * @property numeric $pending_days
 * @property numeric $expiring_days
 * @property string|null $next_expiry_date
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\Leave\LeaveBalanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereAccruedDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereAvailableDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereExpiringDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereNextExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance wherePendingDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveBalance whereUsedDays($value)
 */
	class LeaveBalance extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property int $from_period_id
 * @property int $to_period_id
 * @property int|null $source_entitlement_id
 * @property int|null $target_entitlement_id
 * @property numeric $requested_days
 * @property numeric $approved_days
 * @property string $status
 * @property string|null $reason
 * @property int|null $requested_by
 * @property int|null $approved_by
 * @property string|null $requested_at
 * @property string|null $approved_at
 * @property string|null $expires_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\Leave\LeaveCarryoverFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereApprovedDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereFromPeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereRequestedDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereSourceEntitlementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereTargetEntitlementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereToPeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveCarryover whereUpdatedAt($value)
 */
	class LeaveCarryover extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property int|null $leave_entitlement_id
 * @property numeric $days
 * @property numeric $daily_rate
 * @property numeric $amount
 * @property string $status
 * @property string|null $reason
 * @property int|null $approved_by
 * @property string|null $approved_at
 * @property string|null $processed_at
 * @property string|null $payroll_reference
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\Leave\LeaveEncashmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereDailyRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereLeaveEntitlementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment wherePayrollReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEncashment whereUpdatedAt($value)
 */
	class LeaveEncashment extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property int $leave_policy_id
 * @property int $leave_period_id
 * @property numeric $entitled_days
 * @property numeric $accrued_days
 * @property numeric $used_days
 * @property numeric $expired_days
 * @property numeric $encashed_days
 * @property string|null $expires_at
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\Leave\LeaveEntitlementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereAccruedDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereEncashedDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereEntitledDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereExpiredDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereLeavePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereLeavePolicyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveEntitlement whereUsedDays($value)
 */
	class LeaveEntitlement extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property string $type
 * @property string $start_date
 * @property string $end_date
 * @property int $is_closed
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Leave\LeavePeriodFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePeriod whereUpdatedBy($value)
 */
	class LeavePeriod extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $leave_type_id
 * @property string $name_en
 * @property string $name_ar
 * @property numeric $days_per_year
 * @property string $accrual_frequency
 * @property string $period_type
 * @property int $allow_accumulation
 * @property int $accumulation_periods
 * @property int $allow_management_carryover
 * @property int $expire_unused
 * @property int $encash_on_termination
 * @property numeric|null $pay_rate
 * @property int $is_default
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Leave\LeavePolicyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereAccrualFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereAccumulationPeriods($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereAllowAccumulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereAllowManagementCarryover($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereDaysPerYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereEncashOnTermination($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereExpireUnused($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy wherePayRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy wherePeriodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeavePolicy whereUpdatedBy($value)
 */
	class LeavePolicy extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $leave_type_id
 * @property int $employee_id
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property string|null $reason
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Leave\LeaveRequestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveRequest whereUpdatedBy($value)
 */
	class LeaveRequest extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property int|null $leave_entitlement_id
 * @property int|null $leave_request_id
 * @property string $transaction_type
 * @property numeric $days
 * @property string $transaction_date
 * @property string|null $start_date
 * @property string|null $end_date
 * @property numeric|null $balance_after
 * @property numeric|null $pay_rate
 * @property string|null $expires_at
 * @property string|null $payroll_processed_at
 * @property string|null $reference_type
 * @property int|null $reference_id
 * @property int|null $created_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\Leave\LeaveTransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereBalanceAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereLeaveEntitlementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereLeaveRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction wherePayRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction wherePayrollProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereReferenceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveTransaction whereUpdatedAt($value)
 */
	class LeaveTransaction extends \Eloquent {}
}

namespace App\Models\Leave{
/**
 * @property int $id
 * @property int $no_of_days
 * @property numeric $pay_rate
 * @property string $effective_from
 * @property string|null $effective_to
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Leave\SickLeaveRuleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereEffectiveFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereEffectiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereNoOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule wherePayRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SickLeaveRule whereUpdatedBy($value)
 */
	class SickLeaveRule extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\AcademicRankFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicRank whereUpdatedBy($value)
 */
	class AcademicRank extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\AdministrativeRankFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdministrativeRank whereUpdatedBy($value)
 */
	class AdministrativeRank extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\AppointmentTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentType whereUpdatedBy($value)
 */
	class AppointmentType extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\BankFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bank whereUpdatedBy($value)
 */
	class Bank extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $parent_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedBy($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property string $lang
 * @property int $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\CountryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereUpdatedBy($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\DeductionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deduction whereUpdatedBy($value)
 */
	class Deduction extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property string|null $type
 * @property int $is_active
 * @property int|null $parent_id
 * @property int|null $head_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\DepartmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedBy($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\EarningFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Earning whereUpdatedBy($value)
 */
	class Earning extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\EducationalSublevelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EducationalSublevel whereUpdatedBy($value)
 */
	class EducationalSublevel extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\FamilyRelationshipFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyRelationship whereUpdatedBy($value)
 */
	class FamilyRelationship extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\GenderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gender whereUpdatedBy($value)
 */
	class Gender extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\GpaTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GpaType whereUpdatedBy($value)
 */
	class GpaType extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\IdentityTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IdentityType whereUpdatedBy($value)
 */
	class IdentityType extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\IncludedSpecializationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IncludedSpecialization whereUpdatedBy($value)
 */
	class IncludedSpecialization extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\JobTitleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobTitle whereUpdatedBy($value)
 */
	class JobTitle extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\LeaveTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LeaveType whereUpdatedBy($value)
 */
	class LeaveType extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\ManagerialRoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ManagerialRole whereUpdatedBy($value)
 */
	class ManagerialRole extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\MaritalStatusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaritalStatus whereUpdatedBy($value)
 */
	class MaritalStatus extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\RatingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rating whereUpdatedBy($value)
 */
	class Rating extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\ReligionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Religion whereUpdatedBy($value)
 */
	class Religion extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\SalaryComponentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryComponent whereUpdatedBy($value)
 */
	class SalaryComponent extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\SalaryRevisionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SalaryRevision whereUpdatedBy($value)
 */
	class SalaryRevision extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\ScientificDegreeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScientificDegree whereUpdatedBy($value)
 */
	class ScientificDegree extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\ShortLeaveTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveType whereUpdatedBy($value)
 */
	class ShortLeaveType extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\SpecialNeedFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialNeed whereUpdatedBy($value)
 */
	class SpecialNeed extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int $category_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\SpecialityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Speciality whereUpdatedBy($value)
 */
	class Speciality extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\SpecialityCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialityCategory whereUpdatedBy($value)
 */
	class SpecialityCategory extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\StudyTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyType whereUpdatedBy($value)
 */
	class StudyType extends \Eloquent {}
}

namespace App\Models\Lookup{
/**
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property int $sort_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Lookup\WorkflowFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workflow whereUpdatedBy($value)
 */
	class Workflow extends \Eloquent {}
}

namespace App\Models\Payroll{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $bank_id
 * @property string $iban
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\EmployeeBankFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeBank whereUpdatedBy($value)
 */
	class EmployeeBank extends \Eloquent {}
}

namespace App\Models\Payroll{
/**
 * @property int $id
 * @property int $run_id
 * @property int $employee_id
 * @property int $salary_revision_id
 * @property int|null $days_worked
 * @property numeric $gross_earnings
 * @property numeric $total_deductions
 * @property numeric $net_pay
 * @property string $status
 * @property string|null $remarks
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\PayrollPayslipFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereDaysWorked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereGrossEarnings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereNetPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereRunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereSalaryRevisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereTotalDeductions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPayslip whereUpdatedBy($value)
 */
	class PayrollPayslip extends \Eloquent {}
}

namespace App\Models\Payroll{
/**
 * @property int $id
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property string $pay_date
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\PayrollPeriodFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod wherePayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollPeriod whereUpdatedBy($value)
 */
	class PayrollPeriod extends \Eloquent {}
}

namespace App\Models\Payroll{
/**
 * @property int $id
 * @property int $period_id
 * @property string $run_type
 * @property string $run_date
 * @property string $status
 * @property int $processed_by
 * @property int $approved_by
 * @property string $approved_at
 * @property numeric $total_gross
 * @property numeric $total_deductions
 * @property numeric $total_net
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\PayrollRunFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereProcessedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereRunDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereRunType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereTotalDeductions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereTotalGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereTotalNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollRun whereUpdatedBy($value)
 */
	class PayrollRun extends \Eloquent {}
}

namespace App\Models\Payroll{
/**
 * @property int $id
 * @property int $payslip_id
 * @property int $deduction_id
 * @property numeric $amount
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\PayslipDeductionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereDeductionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction wherePayslipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipDeduction whereUpdatedBy($value)
 */
	class PayslipDeduction extends \Eloquent {}
}

namespace App\Models\Payroll{
/**
 * @property int $id
 * @property int $payslip_id
 * @property int $earning_id
 * @property numeric $amount
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\PayslipEarningFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereEarningId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning wherePayslipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayslipEarning whereUpdatedBy($value)
 */
	class PayslipEarning extends \Eloquent {}
}

namespace App\Models\Payroll\Salary{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $component_id
 * @property numeric $amount
 * @property string $effective_from
 * @property string|null $effective_to
 * @property int $revision_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\Salary\EmployeeSalaryComponentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereEffectiveFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereEffectiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereRevisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryComponent whereUpdatedBy($value)
 */
	class EmployeeSalaryComponent extends \Eloquent {}
}

namespace App\Models\Payroll\Salary{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $revision_type_id
 * @property string $effective_date
 * @property numeric|null $previous_gross
 * @property numeric $new_gross
 * @property string $reason
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Payroll\Salary\EmployeeSalaryRevisionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereNewGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision wherePreviousGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereRevisionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeeSalaryRevision whereUpdatedBy($value)
 */
	class EmployeeSalaryRevision extends \Eloquent {}
}

namespace App\Models\Qualifications{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $major_id
 * @property int|null $minor_id
 * @property int|null $educational_sublevel_id
 * @property int|null $included_specialty_id
 * @property string|null $institution_name
 * @property string|null $college_name
 * @property int|null $scientific_degree_id
 * @property string|null $graduation_date
 * @property int|null $graduation_country_id
 * @property int $is_last_qualification
 * @property int|null $rating_id
 * @property string|null $gpa
 * @property int|null $gpa_type_id
 * @property int|null $study_type_id
 * @property string|null $city
 * @property int $is_authenticated
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Qualifications\QualificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereCollegeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereEducationalSublevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereGpa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereGpaTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereGraduationCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereGraduationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereIncludedSpecialtyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereInstitutionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereIsAuthenticated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereIsLastQualification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereMinorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereRatingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereScientificDegreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereStudyTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Qualification whereUpdatedBy($value)
 */
	class Qualification extends \Eloquent {}
}

namespace App\Models\ShortLeave{
/**
 * @property int $id
 * @property int $employee_id
 * @property int $short_leave_type_id
 * @property string $short_leave_date
 * @property string $short_leave_from
 * @property string $short_leave_to
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\ShortLeave\ShortLeaveRequestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereShortLeaveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereShortLeaveFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereShortLeaveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereShortLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShortLeaveRequest whereUpdatedBy($value)
 */
	class ShortLeaveRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read Employee $employee
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property \Carbon\CarbonImmutable|null $two_factor_confirmed_at
 * @property-read User|null $creator
 * @property-read User|null $editor
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passkeys\Passkey> $passkeys
 * @property-read int|null $passkeys_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 */
	class User extends \Eloquent implements \Laravel\Fortify\Contracts\PasskeyUser, \Laravel\Passkeys\Contracts\PasskeyUser {}
}

namespace App\Models\Workflow{
/**
 * @property int $id
 * @property int $workflow_step_id
 * @property string $actionable_type
 * @property int $actionable_id
 * @property int $actor_id
 * @property int $role_id
 * @property string $action
 * @property string|null $comment
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Workflow\WorkflowActionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereActionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereActionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereActorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowAction whereWorkflowStepId($value)
 */
	class WorkflowAction extends \Eloquent {}
}

namespace App\Models\Workflow{
/**
 * @property int $id
 * @property int $workflow_id
 * @property string $name_en
 * @property string $name_ar
 * @property string|null $code
 * @property string|null $description
 * @property int $step_order
 * @property int $role_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $editor
 * @method static \Database\Factories\Workflow\WorkflowStepFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereStepOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkflowStep whereWorkflowId($value)
 */
	class WorkflowStep extends \Eloquent {}
}

