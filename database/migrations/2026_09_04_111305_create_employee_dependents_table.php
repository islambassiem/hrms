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
        Schema::create('employee_dependents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('identification')->index();
            $table->foreignId('gender_id')->constrained('lookup_genders');
            $table->date('date_of_birth');
            $table->foreignId('relationship_id')->constrained('lookup_family_relationships');
            $table->boolean('has_insurance')->default(false);
            $table->integer('ticket_ratio')->default(0);
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
        Schema::dropIfExists('employee_dependents');
    }
};
