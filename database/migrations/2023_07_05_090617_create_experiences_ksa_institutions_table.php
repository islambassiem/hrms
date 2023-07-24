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
    Schema::create('experiences_ksa_institutions', function (Blueprint $table) {
      $table->id();
      $table->string('empid', 10);
      $table->string('position', 100)->nullable();
      $table->string('institution_code', 10)->nullable();
      $table->string('college', 10)->nullable();
      $table->string('city', 50)->nullable();
      $table->string('section', 10)->nullable();
      $table->string('major_id', 10)->nullable();
      $table->string('minor_id', 10)->nullable();
      $table->string('academic_rank_id', 10)->nullable();
      $table->string('non_academic_rank_id', 10)->nullable();
      $table->date('hiring_date', 10)->nullable();
      $table->date('joining_date')->nullable();
      $table->date('resignation_date')->nullable();
      $table->string('appointment_type', 10)->nullable();
      $table->string('employment_status', 10)->nullable();
      $table->text('tasks')->nullable();
      $table->string('job_type', 10)->nullable();
      $table->string('housing_status', 10)->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();


      //joins
      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('institution_code')->references('code')->on('lk_educational_institutions');
      $table->foreign('city')->references('code')->on('lk_ksa_cities');
      $table->foreign('college')->references('code')->on('lk_ksa_colleges');
      $table->foreign('section')->references('code')->on('lk_academic_sections');
      $table->foreign('academic_rank_code')->references('code')->on('lk_academic_ranks');
      $table->foreign('non_academic_rank_code')->references('code')->on('lk_non_academic_ranks');
      $table->foreign('appointment_type')->references('code')->on('lk_academic_staff_appointment_types');
      $table->foreign('employment_status')->references('code')->on('lk_employement_status_types');
      $table->foreign('job_type')->references('code')->on('lk_job_types');
      $table->foreign('housing_status')->references('code')->on('lk_housing_status_types');
      $table->foreign('attachement')->references('id')->on('attachments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('experiences_ksa_institutions');
  }
};
