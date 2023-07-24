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
    Schema::create('short_leaves', function (Blueprint $table) {
      $table->id();
      $table->string('empid', 10);
      $table->unsignedTinyInteger('type');
      $table->date('date');
      $table->time('start');
      $table->time('end');
      $table->unsignedTinyInteger('approval');
      $table->unsignedBigInteger('attachment_id')->nullable();
      $table->timestamps();

      // joins
      $table->foreign('empid')->references('empid')->on('lk_workflow_status');
      $table->foreign('approval')->references('code')->on('lk_workflow_status');
      $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('short_leaves');
  }
};
