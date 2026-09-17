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
        Schema::create('leave_entitlements', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees');

            $table->foreignId('leave_type_id')
                ->constrained('lookup_leave_types');

            $table->foreignId('leave_policy_id')
                ->constrained('leave_policies')
                ->restrictOnDelete();

            $table->foreignId('leave_period_id')
                ->constrained('leave_periods')
                ->restrictOnDelete();

            /*
             * Total entitlement for this bucket.
             *
             * Example:
             * 21
             * 30
             * 10.5 for a prorated employee
             */
            $table->decimal('entitled_days', 8, 2)->default(0);

            /*
             * Amount actually accrued so far.
             *
             * With monthly accrual, this increases each month.
             */
            $table->decimal('accrued_days', 8, 2)->default(0);

            /*
             * Days consumed from this entitlement bucket.
             */
            $table->decimal('used_days', 8, 2)->default(0);

            /*
             * Days that expired.
             */
            $table->decimal('expired_days', 8, 2)->default(0);

            /*
             * Days encashed.
             */
            $table->decimal('encashed_days', 8, 2)->default(0);

            /*
             * Optional expiration date for this bucket.
             *
             * Especially useful for carry-forward days.
             */
            $table->date('expires_at')->nullable();

            $table->string('status')->default('active');
            // active
            // closed
            // expired

            $table->timestamps();

            $table->unique([
                'employee_id',
                'leave_policy_id',
                'leave_period_id',
            ], 'unique_employee_policy_period');

            $table->index([
                'employee_id',
                'leave_type_id',
            ], 'idx_employee_leave_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_entitlements');
    }
};
