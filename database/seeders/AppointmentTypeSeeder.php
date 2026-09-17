<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Services\DataSeeder;
use Illuminate\Database\Seeder;

class AppointmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataSeeder::run(
            'appointment_types.json',
            'lookup_appointment_types'
        );
    }
}
