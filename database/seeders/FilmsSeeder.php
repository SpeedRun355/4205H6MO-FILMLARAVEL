<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;

class FilmsSeeder extends Seeder
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
            \App\Models\Films::create([
                'name' => $Faker->sentence(3),
                'global_rating' => $Faker->numberBetween(1, 10),
                'film_genre' => $Faker->word(),
                'actors' => $Faker->name() . ', ' . $Faker->name(),
                'director' => $Faker->name(),
            ]);
        }
    }
}
