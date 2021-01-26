<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {
    $date = $this->faker->dateTimeBetween('-3 years' );
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('1234'), // password
        'profile' => $faker->text(),
        'type' => $faker->boolean(),
        'phone' => $faker->regexify('(0)[0-9]{10}'),
        'address' => $faker->address(),
        'dob' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),
        'create_user_id' => $faker->numberBetween(0,1),
        'updated_user_id' => $faker->numberBetween(0,1),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});
