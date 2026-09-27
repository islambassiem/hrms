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
        Schema::create('employee_contracts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('salary_revision_id')->constrained('payroll_employee_salary_revisions');
            $table->foreignId('address_id')->nullable()->constrained('employee_addresses');
            $table->date('start_date');
            $table->integer('duration');
            $table->integer('probation_period');
            $table->integer('notice_period');
            $table->string('type');
            $table->date('end_date');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};
