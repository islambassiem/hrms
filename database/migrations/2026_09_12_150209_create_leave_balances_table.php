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
        Schema::create('leave_balances', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees');

            $table->foreignId('leave_type_id')
                ->constrained('lookup_leave_types');

            /*
             * Total currently accrued/available from all
             * eligible entitlement buckets.
             */
            $table->decimal('available_days', 8, 2)->default(0);

            /*
             * Useful reporting values.
             */
            $table->decimal('accrued_days', 8, 2)->default(0);
            $table->decimal('used_days', 8, 2)->default(0);
            $table->decimal('pending_days', 8, 2)->default(0);

            /*
             * Days that are about to expire.
             */
            $table->decimal('expiring_days', 8, 2)->default(0);

            $table->date('next_expiry_date')->nullable();

            $table->timestamps();

            $table->unique([
                'employee_id',
                'leave_type_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
