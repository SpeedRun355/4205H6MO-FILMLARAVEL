<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\FilmUser;
class Film_UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            FilmUser::create([
                'film_id' => $faker->numberBetween(1, 10),
                'user_id' => $faker->numberBetween(1, 10),
                'review' => $faker->numberBetween(1, 5),
                'comment' => $faker->sentence(),
                'erase' => $faker->boolean(),
            ]);
        }
    }
}
