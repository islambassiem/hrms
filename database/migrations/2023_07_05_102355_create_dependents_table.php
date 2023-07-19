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
    Schema::create('dependents', function (Blueprint $table) {
      $table->unsignedTinyInteger('id', true);
      $table->unsignedSmallInteger('employee_id');
      $table->string('name')->nullable();
      $table->string('identification', 50)->nullable();
      $table->date('date_of_birth')->nullable();
      $table->unsignedTinyInteger('relationship_id')->nullable();
      $table->boolean('ticket')->nullable();
      $table->unsignedBigInteger('attachement')->nullable();
      $table->timestamps();

      // joins
      $table->foreign('employee_id')->references('id')->on('employees');
      $table->foreign('relationship_id')->references('id')->on('lk_family_relationships');
      $table->foreign('attachement')->references('id')->on('attachments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('dependents');
  }
};