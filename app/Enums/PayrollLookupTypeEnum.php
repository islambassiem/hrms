<?php

declare(strict_types=1);

namespace App\Enums;

enum PayrollLookupTypeEnum: int
{
    case SALARY_COMPONENT_TYPES = 1;

    case SALARY_REVISION_TYPES = 2;

    case BANKS = 3;

    case PAYROLL_PERIOD_STATUSES = 4;

    case PAYROLL_PERIOD_RUNS = 5;

    case PAYROLL_RUN_TYPES = 6;

    case PAYROLL_RUN_STATUSES = 7;

    case PAYROLL_PAYSLIP_STATUSES = 8;

    case PAYROLL_PAYSLIP_EARNINGS = 9;

    case PAYROLL_PAYSLIP_DEDUCTIONS = 10;

}
