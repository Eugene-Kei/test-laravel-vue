<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin user
        factory(App\User::class, 1)->create(['is_admin' => 1]);
        //create simple users
        factory(App\User::class, 4)->create();
    }
}
