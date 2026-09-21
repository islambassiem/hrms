<?php

declare(strict_types=1);

dataset('Address Dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('short_address')
        ->required()
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('building_number')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('street')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('secondary_number')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('district')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('postal_code')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('city')
        ->notString()
        ->tooLong(255)
        ->build(),
]);

dataset('dependent dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('identification')
        ->required()
        ->digits(10)
        ->build(),

    ...invalid('name_en')
        ->tooLong(255)
        ->notString()
        ->build(),

    ...invalid('name_ar')
        ->tooLong(255)
        ->notString()
        ->build(),

    ...invalid('gender_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('relationship_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('date_of_birth')
        ->required()
        ->future()
        ->build(),

    ...invalid('has_insurance')
        ->required()
        ->notBoolean()
        ->build(),

    ...invalid('ticket_ratio')
        ->required()
        ->belowMin(0)
        ->aboveMax(100)
        ->build(),
]);

dataset('identity dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('identity_number')
        ->required()
        ->notString()
        ->tooLong(15)
        ->build(),

    ...invalid('identity_type_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('place_of_issue')
        ->notString()
        ->tooLong(255)
        ->build(),

    ...invalid('issue_date')
        ->future()
        ->build(),

    ...invalid('expiry_date')
        ->required()
        ->invalidDateOrder('issue_date', 'expiry_date')
        ->build(),
]);

dataset('job title dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('job_title_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('start_date')
        ->required()
        ->build(),

    ...invalid('end_date')
        ->invalidDateOrder('start_date', 'end_date')
        ->build(),
]);

dataset('managerial role dataset', [
    ...invalid('employee_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('managerial_role_id')
        ->required()
        ->notInteger()
        ->build(),

    ...invalid('start_date')
        ->required()
        ->build(),

    ...invalid('end_date')
        ->invalidDateOrder('start_date', 'end_date')
        ->build(),
]);

dataset('employee dataset', [

    ...invalid('user_id')
        ->required()
        ->build(),

    ...invalid('first_name_en')
        ->required()
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('middle_name_en')
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('third_name_en')
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('last_name_en')
        ->required()
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('first_name_ar')
        ->required()
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('middle_name_ar')
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('third_name_ar')
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('last_name_ar')
        ->required()
        ->notString()
        ->tooLong(30)
        ->build(),

    ...invalid('gender_id')
        ->required()
        ->build(),

    ...invalid('category_id')
        ->required()
        ->build(),

    ...invalid('nationality_id')
        ->required()
        ->build(),

    ...invalid('phone')
        ->notString()
        ->aboveMax(30)
        ->build(),

    ...invalid('image')
        ->notString()
        ->aboveMax(30)
        ->build(),

    ...invalid('date_of_birth')
        ->required()
        ->future()
        ->build(),

    ...invalid('joining_date')
        ->required()
        ->past()
        ->build(),

    ...invalid('leaving_date')
        ->invalidDateOrder('joining_date', 'leaving_date')
        ->build(),

    ...invalid('home_telephone_number')
        ->notString()
        ->aboveMax(30)
        ->build(),

    ...invalid('home_country_identity')
        ->notString()
        ->aboveMax(30)
        ->build(),

    ...invalid('blood_type')
        ->notString()
        ->aboveMax(30)
        ->build(),

    ...invalid('is_active')
        ->notBoolean()
        ->build(),
]);
