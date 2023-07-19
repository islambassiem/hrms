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
    Schema::create('passports', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->unsignedSmallInteger('employee_id')->unique();
      $table->string('passport_number')->nullable();
      $table->string('issuing_place', 100)->nullable();
      $table->date('issuing_date')->nullable();
      $table->date('expiry_date')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();

      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('attachement')->references('id')->on('attachments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('passports');
  }
};
