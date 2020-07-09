<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Student::class, function (Faker $faker) {
    return [
        'name' => 'Test',
        'firstname' => 'Tester',
        'street' => 'Teststrasse',
        'street_no' => '99',
        'zip' => '9999',
        'city' => 'Testhausen',
        'phone' => '999 99 99',
        'mobile' => '999 99 99',
        'user_id' => '99999999-9999-9999-9999-999999999999',
        'country' => 'Switzerland'
    ];
});
