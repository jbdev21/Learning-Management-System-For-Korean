<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'username'  => $faker->unique()->username,
        'name'  => $faker->name,
        'type' => 'student',
        'grade'     => 1,
        'status'    => 1,
        'is_active' => 1,
        'branch_id' => 1,
        'student_contact_number'  => $faker->phoneNumber,
        'parent_contact_number'  => $faker->phoneNumber,
        'branch_id'  => 1,
        'password' => bcrypt("password"),
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),

               // 'username' => "admin",
        // 'name' => $faker->name,
        // 'email' => $faker->unique()->safeEmail,
        // 'type'  => 'administrator',
        // 'status'    => 1,
        // 'is_active' => 1,
        // 'branch_id' => 1,
        // 'contact_number'    => "123232-232",
        // 'email_verified_at' => now(),
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 'remember_token' => Str::random(10),
    ];
});
