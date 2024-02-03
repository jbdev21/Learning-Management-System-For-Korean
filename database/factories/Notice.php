<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Notice;
use Faker\Generator as Faker;

$factory->define(Notice::class, function (Faker $faker) {
    return [
        'title'         => $faker->sentence(),
        'content'       => $faker->paragraph(200),
        'branch_id'     => 1,
        'user_id'       => 1,
        'is_published'  => 1
    ];
});
