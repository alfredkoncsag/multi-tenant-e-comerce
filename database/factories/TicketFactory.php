<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'contact' => $faker->name,
        'status' => $faker->text,
        'issue' => $faker->text
    ];
});
