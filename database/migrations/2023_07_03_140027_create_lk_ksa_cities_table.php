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
    Schema::create('lk_ksa_cities', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->string('city_en');
      $table->string('city_ar');
      $table->string('code', 50)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lk_ksa_cities');
  }
};
