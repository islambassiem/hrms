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
    Schema::create('experiences_non_ksa_institutions', function (Blueprint $table) {
      $table->id();
      $table->unsignedSmallInteger('employee_id');
      $table->string('profession', 100)->nullable();
      $table->string('organization_name', 100)->nullable();
      $table->string('city', 100)->nullable();
      $table->unsignedSmallInteger('country')->nullable();
      $table->string('department', 100)->nullable();
      $table->string('section', 100)->nullable();
      $table->date('start_date')->nullable();
      $table->date('end_date')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->text('functional_tasks')->nullable();
      $table->timestamps();


      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('country')->references('id')->on('lk_countries');
      $table->foreign('attachement')->references('id')->on('attachments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('experiences_non_ksa_institutions');
  }
};
