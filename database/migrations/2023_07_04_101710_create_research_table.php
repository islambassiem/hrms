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
    Schema::create('research', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id');
      $table->unsignedTinyInteger('type')->nullable();
      $table->unsignedTinyInteger('status')->nullable();
      $table->unsignedTinyInteger('progress')->nullable();
      $table->unsignedTinyInteger('nature')->nullable();
      $table->unsignedTinyInteger('domain')->nullable();
      $table->boolean('category_code')->default(1);
      $table->string('title')->nullable();
      $table->date('publishing_date')->nullable();
      $table->string('publisher')->nullable();
      $table->string('isbn', 100)->nullable();
      $table->string('magazine')->nullable();
      $table->string('edition', 10)->nullable();
      $table->unsignedSmallInteger('publication_location')->nullable();
      $table->text('summary')->nullable();
      $table->unsignedSmallInteger('lang')->nullable();
      $table->string('publishing_url')->nullable();
      $table->string('key_words')->nullable();
      $table->timestamps();


      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('type')->references('id')->on('lk_research_types');
      $table->foreign('status')->references('id')->on('lk_research_status');
      $table->foreign('progress')->references('id')->on('lk_research_progress');
      $table->foreign('nature')->references('id')->on('lk_research_nature');
      $table->foreign('domain')->references('id')->on('lk_reseach_domains');
      $table->foreign('publication_location')->references('id')->on('lk_countries');
      $table->foreign('lang')->references('id')->on('lk_research_languages');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('research');
  }
};
