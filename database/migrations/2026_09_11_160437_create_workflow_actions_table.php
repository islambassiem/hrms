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
        Schema::create('workflow_actions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workflow_step_id')->constrained('workflow_steps');
            $table->string('actionable_type');
            $table->unsignedBigInteger('actionable_id');
            $table->foreignId('actor_id')->constrained('employees');
            $table->foreignId('role_id')->constrained('spatie_roles');
            $table->string('action');
            $table->text('comment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index(['actionable_type', 'actionable_id']);
            $table->index('actor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_actions');
    }
};
