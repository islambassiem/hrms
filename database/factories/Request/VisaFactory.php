<?php

namespace Database\Factories\Request;

use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
use App\Enums\VisaStatusEnum;
use App\Models\Employee\Employee;
use App\Models\Request\Visa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<Visa>
 */
class VisaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'start_date' => $startDate = Date::parse(fake()->date()),
            'end_date' => $startDate->addDays(random_int(1, 90)),
            'for_year' => fake()->year(),
            'status' => fake()->randomElement(VisaStatusEnum::cases()),
            'payment' => fake()->randomElement(VisaPaymentEnum::cases()),
            'payer' => fake()->randomElement(VisaPayerEnum::cases()),
        ];
    }
}
