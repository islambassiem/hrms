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
    Schema::create('lk_study_types', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('study_type_en', 100);
      $table->string('study_type_ar', 100);
      $table->string('code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lk_study_types');
  }
};
