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
    Schema::create('lk_reseach_domains', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->string('reseach_domain_en', 50);
      $table->string('reseach_domain_ar', 50);
      $table->string('code', 10)->unique();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lk_reseach_domains');
  }
};
