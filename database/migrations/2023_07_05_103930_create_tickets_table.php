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
    Schema::create('tickets', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->unsignedSmallInteger('employee_id');
      $table->decimal('amount', 8, 2, true)->default(0);
      $table->date('effective');
      $table->timestamps();

      //joins
      $table->foreign('employee_id')->references('id')->on('employees');
    });


  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tickets');
  }
};
