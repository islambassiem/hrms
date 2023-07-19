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
    Schema::create('employees', function (Blueprint $table) {
      $table->unsignedSmallInteger('id', true);
      $table->string('empid', 10)->unique();
      $table->string('first_name_en', 50)->nullable();
      $table->string('middle_name_en', 50)->nullable();
      $table->string('third_name_en', 50)->nullable();
      $table->string('family_name_en', 50)->nullable();
      $table->string('first_name_ar', 50)->nullable();
      $table->string('middle_name_ar', 50)->nullable();
      $table->string('third_name_ar', 50)->nullable();
      $table->string('family_name_ar', 50)->nullable();
      $table->unsignedTinyInteger('gender')->nullable();
      $table->unsignedSmallInteger('nationality')->nullable();
      $table->unsignedTinyInteger('religion')->nullable();
      $table->date('date_of_birth')->nullable();
      $table->unsignedSmallInteger('place_of_birth')->nullable();
      $table->unsignedTinyInteger('marital_status')->nullable();
      $table->date('joining_date')->nullable();
      $table->date('resignation_date')->nullable();
      $table->unsignedSmallInteger('position')->nullable();
      $table->unsignedSmallInteger('sponsorship')->nullable();
      $table->unsignedSmallInteger('section')->nullable();
      $table->unsignedTinyInteger('category')->nullable();
      $table->boolean('active')->default(1);
      $table->boolean('salary')->default(1);
      $table->boolean('fingerprint')->default(1);
      $table->string('cost_center', 10)->nullable();
      $table->boolean('married_contract')->default(0);
      $table->unsignedTinyInteger('vacation_class')->default(0);
      $table->text('notes')->nullable();
      $table->unsignedTinyInteger('special_need')->nullable();
      $table->string('home_country_id', 50)->nullable();
      $table->timestamps();
      /*
      -----------------------------------
      |  Joins
      -----------------------------------
      */
      $table->foreign('gender')->references('id')->on('lk_genders');
      $table->foreign('nationality')->references('id')->on('lk_countries');
      $table->foreign('religion')->references('id')->on('lk_religions');
      $table->foreign('position')->references('id')->on('lk_positions');
      $table->foreign('sponsorship')->references('id')->on('lk_sponsorships');
      $table->foreign('section')->references('id')->on('lk_sections');
      $table->foreign('category')->references('id')->on('lk_categories');
      $table->foreign('special_need')->references('id')->on('lk_special_needs');
      $table->foreign('place_of_birth')->references('id')->on('lk_countries');
      $table->foreign('marital_status')->references('id')->on('lk_marital_statuses');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('employees');
  }
};
