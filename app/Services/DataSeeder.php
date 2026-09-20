<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

final class DataSeeder
{
    public static function run(
        string $filename,
        string $table,
    ): void {
        $fileContent = File::get(database_path("data/$filename"));

        /** @var array<int, array{
         *     code: string,
         *     name_en: string,
         *     name_ar: string,
         * }> $values
         */
        $values = json_decode($fileContent, true);

        foreach ($values as $value) {
            $value['created_at'] = now();
            $value['updated_at'] = now();
            DB::table($table)->insert($value);
        }
    }
}
