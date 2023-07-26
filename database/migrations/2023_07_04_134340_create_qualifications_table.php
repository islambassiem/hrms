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
      $table->string('empid', 10);
      $table->string('qualification', 10)->nullable();
      $table->string('major_id', 10)->nullable();
      $table->string('minor_id', 10)->nullable();
      $table->string('rating', 10)->nullable();
      $table->string('gpa', 10)->nullable();
      $table->string('gpa_type', 10)->nullable();
      $table->string('study_type', 10)->nullable();
      $table->string('graduation_university', 100)->nullable();
      $table->string('graduation_college', 100)->nullable();
      $table->date('graduation_date')->nullable();
      $table->string('city', 100)->nullable();
      $table->string('graduation_country', 10)->nullable();
      $table->string('graduation_type', 10)->nullable();
      $table->boolean('attested')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();

      /*
      -----------------------------------
      |  Joins
      -----------------------------------
      */

      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('qualification')->references('code')->on('lk_qualifications');
      $table->foreign('major_id')->references('code')->on('lk_specialities');
      $table->foreign('minor_id')->references('code')->on('lk_specialities');
      $table->foreign('rating')->references('code')->on('lk_ratings');
      $table->foreign('gpa_type')->references('code')->on('lk_gpa_types');
      $table->foreign('study_type')->references('code')->on('lk_study_types');
      $table->foreign('graduation_country')->references('code')->on('lk_countries');
      $table->foreign('graduation_type')->references('code')->on('lk_qualification_types');
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
