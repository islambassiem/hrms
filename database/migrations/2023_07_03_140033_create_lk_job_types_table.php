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
    Schema::create('lk_job_types', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('job_type_en', 50);
      $table->string('job_type_ar', 50);
      $table->string('code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lk_job_types');
  }
};
