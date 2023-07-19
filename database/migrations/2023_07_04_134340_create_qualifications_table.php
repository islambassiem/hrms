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
    Schema::create('qualifications', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id');
      $table->unsignedTinyInteger('qualification')->nullable();
      $table->unsignedSmallInteger('major_id')->nullable();
      $table->unsignedSmallInteger('minor_id')->nullable();
      $table->unsignedTinyInteger('rating')->nullable();
      $table->string('gpa', 10)->nullable();
      $table->unsignedTinyInteger('gpa_type')->nullable();
      $table->unsignedTinyInteger('study_type')->nullable();
      $table->string('graduation_university', 100)->nullable();
      $table->string('graduation_college', 100)->nullable();
      $table->date('graduation_date')->nullable();
      $table->string('city')->nullable();
      $table->unsignedSmallInteger('graduation_country')->nullable();
      $table->unsignedTinyInteger('graduation_type')->nullable();
      $table->boolean('attested')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();

      /*
            -----------------------------------
            |  Joins
            -----------------------------------
            */

      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('qualification')->references('id')->on('lk_qualifications');
      $table->foreign('major_id')->references('id')->on('lk_specialities');
      $table->foreign('minor_id')->references('id')->on('lk_specialities');
      $table->foreign('rating')->references('id')->on('lk_ratings');
      $table->foreign('gpa_type')->references('id')->on('lk_gpa_types');
      $table->foreign('study_type')->references('id')->on('lk_study_types');
      $table->foreign('graduation_country')->references('id')->on('lk_countries');
      $table->foreign('graduation_type')->references('id')->on('lk_qualification_types');
      $table->foreign('attachement')->references('id')->on('attachments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('qualification');
  }
};
