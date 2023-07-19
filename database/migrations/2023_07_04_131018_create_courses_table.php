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
      $table->unsignedSmallInteger('employee_id');
      $table->string('name', 100)->nullable();
      $table->unsignedTinyInteger('type')->nullable();
      $table->string('issuer', 100)->nullable();
      $table->string('year', 5)->nullable();
      $table->string('period', 100)->nullable();
      $table->string('city', 100)->nullable();
      $table->unsignedSmallInteger('country')->nullable();
      $table->timestamps();


      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('country')->references('id')->on('lk_countries');
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
