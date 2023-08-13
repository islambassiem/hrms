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
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->string('empid', 10);
      $table->string('name', 100)->nullable();
      $table->string('type', 10)->nullable();
      $table->string('issuer', 100)->nullable();
      $table->date('courseDate')->nullable();
      $table->string('period', 100)->nullable();
      $table->string('city', 100)->nullable();
      $table->string('country', 10)->nullable();
      $table->timestamps();


      // joins
      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('type')->references('code')->on('lk_course_types');
      $table->foreign('country')->references('code')->on('lk_countries');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('courses');
  }
};
