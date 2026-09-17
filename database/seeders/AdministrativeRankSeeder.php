<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Services\DataSeeder;
use Illuminate\Database\Seeder;

class AdministrativeRankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataSeeder::run(
            'admin_ranks.json',
            'lookup_administrative_ranks'
        );
    }
}
