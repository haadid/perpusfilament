<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\BookEdit;

class BookEditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookEdit::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'title' => $this->faker->sentence(4),
            'isbn' => $this->faker->word(),
            'year' => $this->faker->numberBetween(-10000, 10000),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'cover' => $this->faker->word(),
            'genres' => $this->faker->text(),
            'categories' => $this->faker->text(),
            'authors' => $this->faker->text(),
            'publishers' => $this->faker->text(),
        ];
    }
}
