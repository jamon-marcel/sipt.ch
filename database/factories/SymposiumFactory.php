<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Symposium;
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

$factory->define(Symposium::class, function (Faker $faker) {
    return [
        'title' => '',
        'subtitle' => '',
        'description' => '',
        'date' => '',
        'cost' => '200.00',
        'location' => '',
        'title' => '',
    ];
});
