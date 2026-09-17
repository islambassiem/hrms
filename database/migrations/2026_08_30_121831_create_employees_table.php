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
        Schema::create('employees', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users');
            $table->foreignId('head_id')->nullable()->constrained('employees');

            $table->string('employee_code', 10)->unique();

            $table->string('first_name_ar', 30);
            $table->string('middle_name_ar', 30)->nullable();
            $table->string('third_name_ar', 30)->nullable();
            $table->string('last_name_ar', 30);

            $table->string('full_name_ar')
                ->storedAs("CONCAT_WS(' ', first_name_ar, middle_name_ar, third_name_ar, last_name_ar)")
                ->index();

            $table->string('first_name_en', 30);
            $table->string('middle_name_en', 30)->nullable();
            $table->string('third_name_en', 30)->nullable();
            $table->string('last_name_en', 30);

            $table->string('full_name_en')
                ->storedAs("CONCAT_WS(' ', first_name_en, middle_name_en, third_name_en, last_name_en)")
                ->index();

            $table->foreignId('marital_status_id')->nullable()->constrained('lookup_marital_statuses');
            $table->foreignId('religion_id')->nullable()->constrained('lookup_religions');
            $table->foreignId('special_need_id')->nullable()->constrained('lookup_special_needs');

            $table->foreignId('gender_id')->constrained('lookup_genders');
            $table->foreignId('category_id')->constrained('lookup_categories');
            $table->foreignId('department_id')->constrained('lookup_departments');
            $table->foreignId('nationality_id')->constrained('lookup_countries');
            $table->foreignId('place_of_birth_id')->nullable()->constrained('lookup_countries');

            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();

            $table->date('date_of_birth')->nullable();
            $table->date('joining_date')->nullable()->index();
            $table->date('leaving_date')->nullable();

            $table->string('home_telephone_number')->nullable();
            $table->string('home_country_identity')->nullable();
            $table->string('blood_type')->nullable();

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index(['department_id', 'is_active']);
        });

        Schema::table('lookup_departments', function (Blueprint $table): void {
            $table->foreign('head_id')
                ->references('id')
                ->on('employees');
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
