<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StudentRankingSeeder::class);
        // $this->call(NoticeSeeder::class);
        // $this->call(StudentSeeder::class);
        // $this->call(InitializationSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
