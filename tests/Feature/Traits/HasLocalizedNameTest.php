<?php

declare(strict_types=1);

use App\Concerns\HasLocalizedName;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

test('test the trait', function (): void {
    #[Fillable('name_en', 'name_ar')]
    /** @property string $name */
    class TestModal extends Model
    {
        use HasFactory;
        use HasLocalizedName;
    }

    $model = new TestModal([
        'name_en' => 'Software Engineer',
        'name_ar' => 'مهندس برمجيات',
    ]);

    app()->setLocale('en');

    expect($model->name)
        ->toBe('Software Engineer');
});
