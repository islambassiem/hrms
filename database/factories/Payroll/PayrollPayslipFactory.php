<?php

declare(strict_types=1);

namespace Database\Factories\Payroll;

use App\Models\Employees\Employee;
use App\Models\Lookup\SalaryRevision;
use App\Models\Payroll\PayrollPayslip;
use App\Models\Payroll\PayrollRun;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PayrollPayslip>
 */
class PayrollPayslipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $grossEarnings = fake()->randomFloat(2, 3000, 30000);
        $totalDeductions = fake()->randomFloat(2, 100, $grossEarnings * 0.25);

        return [
            'run_id' => PayrollRun::factory(),
            'employee_id' => Employee::factory(),
            'salary_revision_id' => SalaryRevision::factory(),
            'days_worked' => fake()->numberBetween(0, 30),
            'gross_earnings' => $grossEarnings,
            'total_deductions' => $totalDeductions,
            'net_pay' => round($grossEarnings - $totalDeductions, 2),
            'status' => fake()->word(),
            'remarks' => fake()->optional()->sentence(8),
        ];
    }

    public function forRunAndEmployee(
        PayrollRun $run,
        Employee $employee
    ): static {
        return $this->state([
            'run_id' => $run->id,
            'employee_id' => $employee->id,
        ]);
    }
}
