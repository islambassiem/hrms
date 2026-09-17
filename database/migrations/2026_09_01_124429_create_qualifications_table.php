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
        Schema::create('qualifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('major_id')->constrained('lookup_qualifications_specialities');
            $table->foreignId('minor_id')->nullable()->constrained('lookup_qualifications_specialities');
            $table->foreignId('educational_sublevel_id')->nullable()->constrained('lookup_qualifications_educational_sublevels');
            $table->foreignId('included_specialty_id')->nullable()->constrained('lookup_qualifications_included_specializations');
            $table->string('institution_name')->nullable();
            $table->string('college_name')->nullable();
            $table->foreignId('scientific_degree_id')->nullable()->constrained('lookup_qualifications_scientific_degrees');
            $table->date('graduation_date')->nullable();
            $table->foreignId('graduation_country_id')->nullable()->constrained('lookup_countries');
            $table->boolean('is_last_qualification')->default(false);

            $table->foreignId('rating_id')->nullable()->constrained('lookup_qualifications_ratings');
            $table->string('gpa')->nullable();
            $table->foreignId('gpa_type_id')->nullable()->constrained('lookup_qualifications_gpa_types');
            $table->foreignId('study_type_id')->nullable()->constrained('lookup_qualifications_study_types');
            $table->string('city')->nullable();
            $table->boolean('is_authenticated')->default(false);
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
        Schema::dropIfExists('qualifications');
    }
};
