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
        Schema::create('leave_encashments', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees');

            $table->foreignId('leave_type_id')
                ->constrained('lookup_leave_types')
                ->restrictOnDelete();

            $table->foreignId('leave_entitlement_id')
                ->nullable()
                ->constrained('leave_entitlements')
                ->restrictOnDelete();

            $table->decimal('days', 8, 2);

            /*
             * Rate used for the calculation.
             * Store it because payroll rates may change later.
             */
            $table->decimal('daily_rate', 10, 2);

            $table->decimal('amount', 12, 2);

            $table->string('status')->default('pending');
            // pending
            // approved
            // processed
            // cancelled

            $table->text('reason')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('employees')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->timestamp('processed_at')->nullable();

            $table->string('payroll_reference')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('leave_encashments');
    }
};
