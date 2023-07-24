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
    Schema::create('letters', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('empid', 10);
      $table->string('addreesee', 100);
      $table->boolean('salary')->default(0);
      $table->boolean('loan')->default(0);
      $table->boolean('attestation')->default(0);
      $table->string('status', 10);
      $table->unsignedBigInteger('attachment_id')->nullable();
      $table->text('details')->nullable();
      $table->timestamps();


      // joins
      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('attachment_id')->references('id')->on('attachments');
      $table->foreign('status')->references('code')->on('lk_workflow_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('letters');
  }
};
