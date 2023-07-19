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
    Schema::create('contacts', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->unsignedSmallInteger('employee_id')->unique();
      $table->string('mobile', 50)->nullable();
      $table->string('home', 50)->nullable();
      $table->string('personal_email', 100)->nullable();
      $table->string('official_email', 100)->nullable();
      $table->string('office_number', 10)->nullable();
      $table->string('extention', 10)->nullable();
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
    Schema::dropIfExists('contacts');
  }
};
