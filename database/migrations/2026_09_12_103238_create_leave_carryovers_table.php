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
        Schema::create('leave_carryovers', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees');

            $table->foreignId('leave_type_id')
                ->constrained('lookup_leave_types')
                ->restrictOnDelete();

            $table->foreignId('from_period_id')
                ->constrained('leave_periods')
                ->restrictOnDelete();

            $table->foreignId('to_period_id')
                ->constrained('leave_periods')
                ->restrictOnDelete();

            $table->foreignId('source_entitlement_id')
                ->nullable()
                ->constrained('leave_entitlements')
                ->restrictOnDelete();

            $table->foreignId('target_entitlement_id')
                ->nullable()
                ->constrained('leave_entitlements')
                ->restrictOnDelete();

            /*
             * What was available for carryover.
             */
            $table->decimal('requested_days', 8, 2);

            /*
             * What management actually approved.
             */
            $table->decimal('approved_days', 8, 2)->default(0);

            $table->string('status')->default('pending');
            // pending
            // approved
            // rejected
            // cancelled

            $table->text('reason')->nullable();

            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            $table->timestamp('requested_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            /*
             * Carry-forward days can have an earlier
             * expiration date than the current year's days.
             */
            $table->date('expires_at')->nullable();

            $table->timestamps();

            $table->index([
                'employee_id',
                'from_period_id',
                'to_period_id',
            ]);

            $table->index([
                'employee_id',
                'status',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_carryovers');
    }
};
