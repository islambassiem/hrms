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
      $table->string('empid', 10);
      $table->string('type', 10);
      $table->date('start');
      $table->date('end');
      $table->unsignedTinyInteger('approval');
      $table->unsignedTinyInteger('attachment_id')->nullable();
      $table->timestamps();


      // joins
      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('type')->references('code')->on('lk_workflow_status');
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
