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
      $table->string('empid', 10);
      $table->string('type_id', 10);
      $table->string('building_no', 5)->nullable();
      $table->string('office_no', 5)->nullable();
      $table->string('status_id', 10);
      $table->text('details')->nullable();
      $table->unsignedBigInteger('attachment_id')->nullable();
      $table->timestamps();

      // joins
      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('type_id')->references('code')->on('lk_maintenance_types');
      $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
      $table->foreign('status_id')->references('code')->on('lk_workflow_status');
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
