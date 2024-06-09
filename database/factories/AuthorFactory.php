<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Author;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $authors =  [
            "Andrea Hirata",
            "Dee Lestari",
            "Tere Liye",
            "Pramodyea Ananta Toer",
            "Ahmad Fuadi",
            "Raditya Dika",
            "J. S. Khairen",
        ];
        $name = fake()->unique()->randomElement($authors);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
