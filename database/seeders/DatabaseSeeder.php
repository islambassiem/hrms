<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Lookup tables
            GenderSeeder::class,
            MaritalStatusSeeder::class,
            ReligionSeeder::class,
            SpecialNeedSeeder::class,
            IdentityTypeSeeder::class,
            AcademicRankSeeder::class,
            AdministrativeRankSeeder::class,
            AppointmentTypeSeeder::class,
            FamilyRelationshipSeeder::class,
            ScientificDegreeSeeder::class,
            EducationalSublevelSeeder::class,
            RatingSeeder::class,
            GpaTypeSeeder::class,
            StudyTypeSeeder::class,
            SalaryComponentSeeder::class,
            SalaryRevisionSeeder::class,
            BankSeeder::class,
            EarningSeeder::class,
            DeductionSeeder::class,
            DepartmentSeeder::class,
            CountrySeeder::class,
            EmployeeCategorySeeder::class,
            QualificationSpecialityCategorySeeder::class,
            QualificationSpecialitySeeder::class,
            QualificationIncludedSpecializationSeeder::class,
            JobTitleSeeder::class,
            ManagerialRoleSeeder::class,
            ShortLeaveTypeSeeder::class,
            LeaveTypeSeeder::class,
            WorkflowSeeder::class,

            // Data tables
            EmployeeSeeder::class,
            EmployeeIdentitySeeder::class,
            QualificationSeeder::class,
            EmployeeJobTitleSeeder::class,
            EmployeeManagerialRoleSeeder::class,
            EmployeeAddressSeeder::class,
            EmployeeDependentSeeder::class,
            EmployeeSalaryRevisionSeeder::class,
            EmployeeSalaryComponentSeeder::class,
            EmployeeBankSeeder::class,
            PayrollPeriodSeeder::class,
            PayrollRunSeeder::class,
            PayrollPayslipSeeder::class,
            WorkflowStepSeeder::class,
            WorkflowActionSeeder::class,
            PayslipEarningSeeder::class,
            PayslipDeductionSeeder::class,
            LeaveRequestSeeder::class,
            LeavePolicySeeder::class,
            EmployeeLeavePolicySeeder::class,
            LeavePeriodSeeder::class,
            LeaveEntitlementSeeder::class,
            LeaveCarryoverSeeder::class,
            LeaveTransactionSeeder::class,
            LeaveEncashmentSeeder::class,
            LeaveBalanceSeeder::class,
            SickLeaveRuleSeeder::class,
            EmployeeSickLeaveCycleSeeder::class,
            ShortLeaveRequestSeeder::class,
        ]);
    }
}
