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
    Schema::create('short_leave_details', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('short_leave_id');
      $table->unsignedTinyInteger('status');
      $table->text('comment');
      $table->unsignedSmallInteger('commenter_id');
      $table->timestamps();


      // joins
      $table->foreign('short_leave_id')->references('id')->on('short_leaves');
      $table->foreign('status')->references('id')->on('lk_workflow_status');
      $table->foreign('commenter_id')->references('id')->on('employees');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('short_leave_details');
  }
};
