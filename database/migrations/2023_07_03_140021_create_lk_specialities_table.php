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
    Schema::create('lk_specialities', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->string('speciality_en');
      $table->string('speciality_ar');
      $table->string('code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lk_specialities');
  }
};
