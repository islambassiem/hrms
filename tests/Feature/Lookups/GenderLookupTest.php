<?php

use App\Lookups\GenderLookup;
use App\Models\Lookup\Gender;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

it('returns genders from database when the cache is clear', function () {
    Gender::factory()->count(2)->create();
    $genders = Gender::query()->get();

    $queries = [];

    DB::listen(function (QueryExecuted $query) use (&$queries) {
        $queries[] = $query->sql;
    });

    $result = resolve(GenderLookup::class)->get();

    $genderQueries = collect($queries)
        ->filter(fn (string $sql) => str_contains(
            strtolower($sql),
            'genders'
        ));

    expect($result->modelKeys())->toEqual($genders->modelKeys())
        ->and($genderQueries)->toHaveCount(1);
});

it('returns genders from cache without querying database', function () {
    Gender::factory()->count(2)->create();

    $genders = Gender::query()->get();

    Cache::put('genders', $genders);

    $queries = [];

    DB::listen(function (QueryExecuted $query) use (&$queries) {
        $queries[] = $query->sql;
    });

    $result = resolve(GenderLookup::class)->get();

    $genderQueries = collect($queries)
        ->filter(fn (string $sql) => str_contains(
            strtolower($sql),
            'genders'
        ));

    expect($result->modelKeys())->toEqual($genders->modelKeys())
        ->and($genderQueries)->toBeEmpty();
});

it('clears the genders cache when a gender is created', function () {
    resolve(GenderLookup::class)->get();

    Gender::factory()->create();

    expect(Cache::has('genders'))->toBeFalse();
});

it('clears the genders cache when a gender is updated', function () {
    resolve(GenderLookup::class)->get();
    $gender = Gender::factory()->create();
    $gender->update(['name_en' => 'Updated Gender']);

    expect(Cache::has('genders'))->toBeFalse();
});

it('clears the genders cache when a gender is deleted', function () {
    resolve(GenderLookup::class)->get();
    $gender = Gender::factory()->create();

    $gender->delete();

    expect(Cache::has('genders'))->toBeFalse();
});

it('refreshes the genders cache after a gender is created', function () {
    $gender = Gender::factory()->create();
    $lookup = resolve(GenderLookup::class);

    $firstResult = $lookup->get();

    $newGender = Gender::factory()->create();
    $secondResult = $lookup->get();

    expect($firstResult->contains('id', $gender->id))->toBeTrue();
    expect($secondResult->contains('id', $newGender->id))->toBeTrue()
        ->and($secondResult)->toHaveCount(2);
});
