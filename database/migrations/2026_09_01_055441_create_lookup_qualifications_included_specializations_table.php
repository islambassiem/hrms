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
        Schema::create('lookup_qualifications_included_specializations', function (Blueprint $table): void {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('code')->unique()->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->foreignId('created_by')->nullable()->constrained('users', indexName: 'idx_included_specializations_created_by');
            $table->foreignId('updated_by')->nullable()->constrained('users', indexName: 'idx_included_specializations_updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lookup_qualifications_included_specializations');
    }
};
