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
    Schema::create('addresses', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id')->unique();
      $table->string('buliding_no', 10)->nullable();
      $table->string('street_name', 50)->nullable();
      $table->string('district_name', 50)->nullable();
      $table->string('city', 50)->nullable();
      $table->string('zip_code', 10)->nullable();
      $table->string('additional_number', 10)->nullable();
      $table->string('unit_number', 10)->nullable();
      $table->timestamps();


      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('addresses');
  }
};
