<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PayrollLookupTypeEnum;
use App\Services\DataSeeder;
use Illuminate\Database\Seeder;

class PayrollLookupValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = PayrollLookupTypeEnum::cases();

        foreach ($types as $type) {
            $filename = strtolower($type->name).'.json';
            DataSeeder::run(
                filename: $filename,
                table: 'payroll_lookup_values',
                // lookup_type_id: $type->value
            );
        }
    }
}
