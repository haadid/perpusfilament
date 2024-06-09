<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Genre;

class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $genres = ['Komedi', 'Sejarah', 'Romansa', 'Sains', 'Fiksi Ilmiah'];
        $name = fake()->unique()->randomElement($genres);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
