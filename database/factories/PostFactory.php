<?php

use Faker\Generator as Faker;

$factory->define(App\Posts::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),
        'detail' => $faker->text(20),
        'author' => $faker->sentence(),
    ];
});
