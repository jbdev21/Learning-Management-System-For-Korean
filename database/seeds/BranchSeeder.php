<?php

use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Models\Branch::class, 1)
            ->create()
            ->each(function ($branch) {
                $branch->users()->save(factory(App\Models\User::class)->create([
                    'username' => 'superadmin',
                    'password' => bcrypt('nelly2020'),
                    'name' => 'Administrator'
                ]));
            });
    }
}
