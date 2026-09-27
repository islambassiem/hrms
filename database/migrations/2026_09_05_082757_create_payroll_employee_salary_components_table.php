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
        Schema::create('payroll_employee_salary_components', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('revision_id')->constrained('lookup_payroll_salary_revisions')->cascadeOnDelete();
            $table->foreignId('component_id')->constrained('lookup_payroll_salary_components');
            $table->decimal('amount', 12, 2);
            $table->date('effective_from')->index();
            $table->date('effective_to')->nullable();
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
        Schema::dropIfExists('payroll_employee_salary_components');
    }
};
