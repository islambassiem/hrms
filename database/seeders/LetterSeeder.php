<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Request\Letter;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Letter::factory(50)->create();
    }
}
