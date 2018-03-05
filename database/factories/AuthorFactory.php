<?php

use Faker\Generator as Faker;

$factory->define(App\Author::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail, // email unique
        'address' => $faker->address,
        'phone' => $faker->phoneNumber // voir la documentation Faker sur Github
    ];
});
