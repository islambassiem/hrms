<?php

declare(strict_types=1);

use App\Concerns\HasLocalizedName;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

test('test the trait', function (): void {
    $model = new
    #[Fillable('name_en', 'name_ar')]
    class(['name_en' => 'Software Engineer', 'name_ar' => 'مهندس برمجيات']) extends Model
    {
        use HasFactory;
        use HasLocalizedName;
    };

    app()->setLocale('en');

    expect($model->name)
        ->toBe('Software Engineer');
});
