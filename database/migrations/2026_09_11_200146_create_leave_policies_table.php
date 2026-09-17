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
        Schema::create('leave_policies', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('leave_type_id')
                ->constrained('lookup_leave_types')
                ->restrictOnDelete();

            $table->string('name_en');
            $table->string('name_ar');

            /*
             * Annual entitlement.
             *
             * 21 for operational staff
             * 30 for faculty
             */
            $table->decimal('days_per_year', 4, 2);

            /*
             * How entitlement is earned.
             *
             * monthly
             * yearly
             */
            $table->string('accrual_frequency')->default('monthly');

            /*
             * Which period this policy uses.
             *
             * calendar_year
             * academic_year
             */
            $table->string('period_type')->default('calendar_year');

            /*
             * Whether unused entitlement can normally
             * remain available into another period.
             */
            $table->boolean('allow_accumulation')->default(false);

            /*
             * Number of periods that can participate
             * in accumulation.
             *
             * Example:
             * 2 = 21 + 21 = 42
             * 2 = 30 + 30 = 60
             */
            $table->unsignedTinyInteger('accumulation_periods')->default(1);

            /*
             * Whether management may approve an
             * exception to the normal expiration rule.
             */
            $table->boolean('allow_management_carryover')->default(false);

            /*
             * Normally unused leave expires when the
             * applicable period closes.
             */
            $table->boolean('expire_unused')->default(true);

            /*
             * When an employee terminates, remaining
             * eligible leave can be encashed.
             */
            $table->boolean('encash_on_termination')->default(true);

            /*
             * Optional default daily payroll rate.
             * I would NOT use this as the actual payroll
             * calculation; it is only a policy setting if needed.
             */
            $table->decimal('pay_rate', 5, 2)->nullable();

            $table->boolean('is_default')->default(false);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['leave_type_id', 'period_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_policies');
    }
};
