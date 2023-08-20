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
      $table->string('contact', 100);
      $table->string('contact_type', 50);
      // $table->string('empid', 10)->unique();
      // $table->string('mobile', 50)->nullable();
      // $table->string('home', 50)->nullable();
      // $table->string('personal_email', 100)->nullable();
      // $table->string('official_email', 100)->nullable();
      // $table->string('office_number', 10)->nullable();
      // $table->string('extention', 10)->nullable();
      $table->timestamps();

      // joins
      $table->foreign('empid')->references('empid')->on('employees');
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
