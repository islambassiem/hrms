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
        Schema::create('leave_transactions', function (Blueprint $table): void {
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

            $table->foreignId('leave_request_id')
                ->nullable()
                ->constrained('leave_requests')
                ->restrictOnDelete();

            /*
             * Examples:
             *
             * accrual
             * leave_taken
             * carryover_in
             * expiration
             * adjustment
             * encashment
             */
            $table->string('transaction_type');

            /*
             * Positive = adding leave
             * Negative = consuming/removing leave
             */
            $table->decimal('days', 8, 2);

            $table->date('transaction_date');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            /*
             * Snapshot of the balance after this transaction.
             */
            $table->decimal('balance_after', 8, 2)->nullable();

            /*
             * Payroll information.
             */
            $table->decimal('pay_rate', 10, 2)->nullable();

            $table->date('expires_at')->nullable();

            $table->timestamp('payroll_processed_at')->nullable();

            /*
             * Polymorphic source.
             *
             * Example:
             * carryover
             * encashment
             * manual adjustment
             */
            $table->nullableMorphs('reference');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users');

            $table->timestamps();

            $table->index([
                'employee_id',
                'leave_type_id',
                'transaction_date',
            ], 'idx_employee_leave_type_transaction_date');

            $table->index([
                'leave_entitlement_id',
                'transaction_date',
            ], 'idx_leave_entitlement_transaction_date');

            $table->index('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_transactions');
    }
};
