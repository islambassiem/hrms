<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Request\Visa;
use Illuminate\Database\Seeder;

class VisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Visa::factory(50)->create();
    }
}
