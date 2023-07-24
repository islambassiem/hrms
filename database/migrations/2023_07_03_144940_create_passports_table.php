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
      $table->string('empid', 10)->unique();
      $table->string('passport_number')->nullable();
      $table->string('issuing_place', 100)->nullable();
      $table->date('issuing_date')->nullable();
      $table->date('expiry_date')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();

      // joins
      $table->foreign('empid')->references('empid')->on('employees');
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
