<?php

use Illuminate\Database\Seeder;

class InitializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        StudentRankingSeeder::run();
        
        // // Make main branch
        // factory(App\Models\Branch::class, 1)->create();

        // // Make super-administrator
        // factory(App\Models\User::class, 1)->create();
        
        //Make students
        // factory(App\Models\User::class, 500)->make(['type' => 'student']);

    }
}
