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
      $table->string('empid', 10);
      $table->string('type', 10)->nullable();
      $table->string('status', 10)->nullable();
      $table->string('progress', 10)->nullable();
      $table->string('nature', 10)->nullable();
      $table->string('domain', 10)->nullable();
      $table->boolean('category_code')->default(1);
      $table->string('title')->nullable();
      $table->date('publishing_date')->nullable();
      $table->string('publisher')->nullable();
      $table->string('isbn', 100)->nullable();
      $table->string('magazine')->nullable();
      $table->string('edition', 10)->nullable();
      $table->string('publication_location', 10)->nullable();
      $table->text('summary')->nullable();
      $table->string('lang', 10)->nullable();
      $table->string('publishing_url')->nullable();
      $table->string('key_words')->nullable();
      $table->timestamps();


      $table->foreign('empid')->references('empid')->on('employees');
      $table->foreign('type')->references('code')->on('lk_research_types');
      $table->foreign('status')->references('code')->on('lk_research_status');
      $table->foreign('progress')->references('code')->on('lk_research_progress');
      $table->foreign('nature')->references('code')->on('lk_research_nature');
      $table->foreign('domain')->references('code')->on('lk_reseach_domains');
      $table->foreign('publication_location')->references('code')->on('lk_countries');
      $table->foreign('lang')->references('code')->on('lk_languages');
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
