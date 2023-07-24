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
    Schema::create('bank_accounts', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->string('empid', 10)->unique();
      $table->string('iban', 50);
      $table->unsignedTinyInteger('bank_id');
      $table->timestamps();

      //joins
      $table->foreign('empid')->references('empid')->on('employees');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('bank_accounts');
  }
};
