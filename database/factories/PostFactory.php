<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'description' => $faker->text(),
        'status' => $faker->boolean(),
        'create_user_id' => $faker->numberBetween(0,1),
        'updated_user_id' => $faker->numberBetween(0,1)
    ];
});
