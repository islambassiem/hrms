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
    Schema::create('attachments', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id');
      $table->unsignedTinyInteger('attachment_type')->nullable();
      $table->string('link')->nullable();
      $table->string('title', 50)->nullable();
      $table->timestamps();

      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('attachment_type')->references('id')->on('lk_attachment_types');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attachments');
  }
};
