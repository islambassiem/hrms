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
    Schema::create('maintenance_requests', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id');
      $table->unsignedTinyInteger('type_id');
      $table->string('building_no', 5)->nullable();
      $table->string('office_no', 5)->nullable();
      $table->unsignedTinyInteger('status_id');
      $table->text('details')->nullable();
      $table->unsignedBigInteger('attachment_id')->nullable();
      $table->timestamps();

      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('type_id')->references('id')->on('lk_maintenance_types');
      $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
      $table->foreign('status_id')->references('id')->on('lk_workflow_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('maintenance_requests');
  }
};
