<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Course::class, function ($faker) {
    $name = $faker->unique()->city;

    return [
        'name' => $name,
        'slug' => Str::slug($name)
    ];
});

$factory->define(App\TeeSet::class, function ($faker) {
    return [
        'sss' => $faker->numberBetween(68, 72)
    ];
});

$factory->define(App\Hole::class, function ($faker) {
    $pars = [3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5];

    return [
        'par' => $faker->randomElement($pars)
    ];
});

$factory->define(App\Score::class, function ($faker) {
    return [
        'strokes' => $faker->numberBetween(3, 6),
        'putts' => $faker->numberBetween(1, 2),
        'fairway' => null,
        'gir' => null
    ];
});

$factory->define(App\Round::class, function ($faker) {
    return [
        'date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d')
    ];
});
