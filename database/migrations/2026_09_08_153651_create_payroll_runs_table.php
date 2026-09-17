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
        Schema::create('payroll_runs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('period_id')->constrained('payroll_periods');
            $table->string('run_type');
            $table->date('run_date');
            $table->string('status');
            $table->foreignId('processed_by')->constrained('employees');
            $table->foreignId('approved_by')->constrained('employees');
            $table->timestamp('approved_at');
            $table->decimal('total_gross')->default(0);
            $table->decimal('total_deductions')->default(0);
            $table->decimal('total_net')->default(0);
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
        Schema::dropIfExists('payroll_runs');
    }
};
