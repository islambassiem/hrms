<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_payslips', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('run_id')->constrained('payroll_runs');
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('salary_revision_id')->constrained('payroll_employee_salary_revisions');
            $table->integer('days_worked')->nullable();
            $table->decimal('gross_earnings')->default(0);
            $table->decimal('total_deductions')->default(0);
            $table->decimal('net_pay')->default(0);
            $table->string('status');
            $table->string('remarks', 255)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index('status', 'idx_payslips_status');
            $table->unique(['run_id', 'employee_id'], 'uq_payslips_run_employee');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_payslips');
    }
};
