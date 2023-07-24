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
    Schema::create('visas', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->string('empid', 10);
      $table->date('departure');
      $table->date('arrival');
      $table->string('status', 10);
      $table->timestamps();


      // joins
      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('status')->references('code')->on('lk_workflow_status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visas');
  }
};
