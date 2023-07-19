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
    Schema::create('lk_employement_status_types', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('employement_status_type_en');
      $table->string('employement_status_type_ar');
      $table->string('code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lk_employement_status_types');
  }
};
