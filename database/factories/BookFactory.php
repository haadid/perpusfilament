<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'book_code' => $this->faker->word(),
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(),
            'isbn' => $this->faker->word(),
            'year' => $this->faker->numberBetween(-10000, 10000),
            'description' => $this->faker->text(),
            'cover' => $this->faker->word(),
        ];
    }
}
