<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Services\DataSeeder;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataSeeder::run(
            filename: 'organizations.json',
            table: 'organizations'
        );
    }
}
