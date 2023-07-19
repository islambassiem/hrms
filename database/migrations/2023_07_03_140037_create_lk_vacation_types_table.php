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
        Schema::create('lk_vacation_types', function (Blueprint $table) {
          $table->unsignedTinyInteger('id', true);
          $table->string('vacation_type_en', 50);
          $table->string('vacation_type_ar', 50);
          $table->string('vacation_type_code', 10)->unique();
          $table->unsignedTinyInteger('ordering');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lk_vacation_types');
    }
};
