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
      $table->string('empid', 10);
      $table->decimal('amount', 8, 2, true)->default(0);
      $table->date('effective');
      $table->timestamps();

      //joins
      $table->foreign('empid')->references('empid')->on('employees');
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
