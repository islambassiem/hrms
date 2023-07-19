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
    Schema::create('family_visits', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->unsignedSmallInteger('employee_id');
      $table->string('request_number',50);
      $table->unsignedTinyInteger('status');
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
    Schema::dropIfExists('family_visits');
  }
};
