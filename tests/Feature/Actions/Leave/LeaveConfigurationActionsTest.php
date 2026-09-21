<?php

declare(strict_types=1);

use App\Actions\Leave\LeavePeriodCreateAction;
use App\Actions\Leave\LeavePeriodUpdateAction;
use App\Actions\Leave\SickLeaveRuleCreateAction;
use App\Actions\Leave\SickLeaveRuleUpdateAction;
use App\Data\Leave\LeavePeriodData;
use App\Data\Leave\SickLeaveRuleData;
use App\Models\Leave\LeavePeriod;
use App\Models\Leave\SickLeaveRule;
use Carbon\CarbonImmutable;
use Illuminate\Validation\ValidationException;

it('creates and updates a leave period', function (): void {
    $data = new LeavePeriodData(
        name_en: '2026 Academic Year',
        name_ar: 'السنة الأكاديمية 2026',
        code: 'AY-2026',
        type: 'academic_year',
        start_date: CarbonImmutable::parse('2026-09-01'),
        end_date: CarbonImmutable::parse('2027-08-31'),
    );

    $period = (new LeavePeriodCreateAction)->handle($data);
    $updated = (new LeavePeriodUpdateAction)->handle($period, new LeavePeriodData(
        name_en: '2026-2027 Academic Year',
        name_ar: 'السنة الأكاديمية 2026-2027',
        code: 'AY-2026',
        type: 'academic_year',
        start_date: CarbonImmutable::parse('2026-09-01'),
        end_date: CarbonImmutable::parse('2027-08-31'),
        is_closed: true,
    ));

    expect($period)->toBeInstanceOf(LeavePeriod::class)
        ->and($updated)->toBeInstanceOf(LeavePeriod::class)
        ->and($updated->is_closed)->toBe(1);
});

it('rejects a leave period with an invalid date range', function (): void {
    (new LeavePeriodCreateAction)->handle(new LeavePeriodData(
        name_en: 'Invalid period',
        name_ar: 'فترة غير صالحة',
        code: 'INVALID',
        type: 'calendar_year',
        start_date: CarbonImmutable::parse('2027-01-02'),
        end_date: CarbonImmutable::parse('2027-01-01'),
    ));
})->throws(ValidationException::class);

it('creates and updates a sick leave rule', function (): void {
    $rule = (new SickLeaveRuleCreateAction)->handle(new SickLeaveRuleData(
        no_of_days: 30,
        pay_rate: 100.0,
        effective_from: CarbonImmutable::parse('2026-01-01'),
    ));

    $updated = (new SickLeaveRuleUpdateAction)->handle($rule, new SickLeaveRuleData(
        no_of_days: 60,
        pay_rate: 75.0,
        effective_from: CarbonImmutable::parse('2026-01-01'),
        effective_to: CarbonImmutable::parse('2026-12-31'),
    ));

    expect($rule)->toBeInstanceOf(SickLeaveRule::class)
        ->and($updated->no_of_days)->toBe(60);
});
