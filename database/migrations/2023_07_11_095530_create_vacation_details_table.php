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
    Schema::create('vacation_details', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('vacation_id');
      $table->unsignedTinyInteger('status');
      $table->text('comment')->nullable();
      $table->unsignedSmallInteger('commenter_id');
      $table->timestamps();


      // joins
      $table->foreign('vacation_id')->references('id')->on('vacations');
      $table->foreign('status')->references('id')->on('lk_workflow_status');
      $table->foreign('commenter_id')->references('id')->on('employees');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vacation_details');
  }
};
