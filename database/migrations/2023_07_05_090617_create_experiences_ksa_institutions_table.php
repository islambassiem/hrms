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
      $table->unsignedSmallInteger('employee_id');
      $table->string('position', 100)->nullable();
      $table->unsignedTinyInteger('institution_code')->nullable();
      $table->unsignedSmallInteger('college')->nullable();
      $table->unsignedSmallInteger('city')->nullable();
      $table->unsignedSmallInteger('section')->nullable();
      $table->unsignedSmallInteger('major_id')->nullable();
      $table->unsignedSmallInteger('minor_id')->nullable();
      $table->unsignedTinyInteger('academic_rank_id')->nullable();
      $table->unsignedTinyInteger('non_academic_rank_id')->nullable();
      $table->date('hiring_date')->nullable();
      $table->date('joining_date')->nullable();
      $table->date('resignation_date')->nullable();
      $table->unsignedTinyInteger('appointment_type')->nullable();
      $table->unsignedTinyInteger('employment_status')->nullable();
      $table->text('tasks')->nullable();
      $table->unsignedTinyInteger('job_type')->nullable();
      $table->unsignedTinyInteger('housing_status')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();


      //joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('institution_code')->references('id')->on('lk_educational_institutions');
      $table->foreign('city')->references('id')->on('lk_ksa_cities');
      $table->foreign('college')->references('id')->on('lk_ksa_colleges');
      $table->foreign('section')->references('id')->on('lk_academic_sections');
      $table->foreign('academic_rank_id')->references('id')->on('lk_academic_ranks');
      $table->foreign('non_academic_rank_id')->references('id')->on('lk_non_academic_ranks');
      $table->foreign('appointment_type')->references('id')->on('lk_academic_staff_appointment_types');
      $table->foreign('employment_status')->references('id')->on('lk_employement_status_types');
      $table->foreign('job_type')->references('id')->on('lk_job_types');
      $table->foreign('housing_status')->references('id')->on('lk_housing_status_types');
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
