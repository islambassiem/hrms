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
    Schema::create('identifications', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id')->unique();
      $table->string('number', 20)->unique();
      $table->unsignedSmallInteger('position')->nullable();
      $table->date('expiry')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();


      // joins

      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('position')->references('id')->on('lk_positions');
      $table->foreign('attachement')->references('id')->on('attachments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('identifications');
  }
};
