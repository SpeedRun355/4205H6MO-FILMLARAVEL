<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $Faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            \App\Models\User::create([
                'name' => $Faker->name(),
                'surname' => $Faker->name(),
                'birthday' => $Faker->date(),
                'username' => $Faker->unique()->userName(),
                'password' => bcrypt('password'),
            ]);
        }
    }
}
