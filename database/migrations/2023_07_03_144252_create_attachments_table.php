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
      $table->string('empid', 10);
      $table->string('attachment_type', 10)->nullable();
      $table->string('link')->nullable();
      $table->string('title', 50)->nullable();
      $table->timestamps();

      // joins
      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('attachment_type')->references('code')->on('lk_attachment_types');
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
