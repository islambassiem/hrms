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
    Schema::create('visas', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->unsignedSmallInteger('employee_id');
      $table->date('departure');
      $table->date('arrival');
      $table->unsignedTinyInteger('status');
      $table->timestamps();


      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('status')->references('id')->on('lk_workflow_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visas');
  }
};
