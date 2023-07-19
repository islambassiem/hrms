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
    Schema::create('vacations', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id');
      $table->unsignedTinyInteger('type');
      $table->date('start');
      $table->date('end');
      $table->unsignedTinyInteger('approval');
      $table->unsignedTinyInteger('attachment_id')->nullable();
      $table->timestamps();


      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('type')->references('id')->on('lk_workflow_status');
      $table->foreign('attachment_id')->references('id')->on('lk_attachment_types')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vacations');
  }
};
