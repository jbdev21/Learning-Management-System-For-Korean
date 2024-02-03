<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Branch;
use Faker\Generator as Faker;

$factory->define(App\Models\Branch::class, function (Faker $faker) {
    return [
        'center_name' => "Main Branch",
        'fax_number'    => '1231',
        'contact_number' => '1231231',
        'address'       => $faker->address,
        'email_address'       => $faker->safeEmail,
    ];
});
