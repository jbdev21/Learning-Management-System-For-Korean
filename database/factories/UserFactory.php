<?php

use App\Models\User;
use Illuminate\Support\Str;
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
    return [
        'username' => "admin",
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'type'  => 'administrator',
        'status'    => 1,
        'is_active' => 1,
        'branch_id' => 1,
        'contact_number'    => "123232-232",
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),


        // for student
        // 'username'  => $faker->unique()->username,
        // 'email' => $faker->unique()->safeEmail,
        // 'name'  => $faker->name,
        // 'type' => 'student',
        // 'grade'     => 1,
        // 'status'    => 1,
        // 'is_active' => 1,
        // 'branch_id' => 1,
        // 'contact_number'  => $faker->phoneNumber,
        // 'parent_contact_number'  => $faker->phoneNumber,
        // 'branch_id'  => 1,
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        // 'email_verified_at' => now(),
        // 'remember_token' => Str::random(10),
    ];
});
