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
      $table->string('head', 10);
      $table->string('first_name_en', 50)->nullable();
      $table->string('middle_name_en', 50)->nullable();
      $table->string('third_name_en', 50)->nullable();
      $table->string('family_name_en', 50)->nullable();
      $table->string('first_name_ar', 50)->nullable();
      $table->string('middle_name_ar', 50)->nullable();
      $table->string('third_name_ar', 50)->nullable();
      $table->string('family_name_ar', 50)->nullable();
      $table->string('gender', 10)->nullable();
      $table->string('nationality', 10)->nullable();
      $table->string('religion', 10)->nullable();
      $table->date('date_of_birth')->nullable();
      $table->string('place_of_birth', 10)->nullable();
      $table->string('marital_status', 10)->nullable();
      $table->date('joining_date')->nullable();
      $table->date('resignation_date')->nullable();
      $table->string('position',10)->nullable();
      $table->string('sponsorship', 10)->nullable();
      $table->string('section',10)->nullable();
      $table->string('category',10)->nullable();
      $table->boolean('active')->default(1);
      $table->boolean('salary')->default(1);
      $table->boolean('fingerprint')->default(1);
      $table->string('cost_center', 10)->nullable();
      $table->boolean('married_contract')->default(0);
      $table->unsignedTinyInteger('vacation_class')->default(0);
      $table->text('notes')->nullable();
      $table->string('special_need',10)->nullable();
      $table->string('home_country_id', 50)->nullable();
      $table->timestamps();
      /*
      -----------------------------------
      |  Joins
      -----------------------------------
      */
      $table->foreign('gender')->references('code')->on('lk_genders');
      $table->foreign('nationality')->references('code')->on('lk_countries');
      $table->foreign('religion')->references('code')->on('lk_religions');
      $table->foreign('position')->references('code')->on('lk_positions');
      $table->foreign('sponsorship')->references('code')->on('lk_sponsorships');
      $table->foreign('section')->references('code')->on('lk_sections');
      $table->foreign('category')->references('code')->on('lk_categories');
      $table->foreign('special_need')->references('code')->on('lk_special_needs');
      $table->foreign('place_of_birth')->references('code')->on('lk_countries');
      $table->foreign('marital_status')->references('code')->on('lk_marital_statuses');
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
