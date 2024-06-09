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
            'book_code' => Str::random(4),
            'title' => fake()->sentence(3),
            'slug' => '',
            'isbn' => fake()->isbn10(),
            'year' => rand(1900, now()->year),
            'description' => fake()->sentence(6),
        ];
    }

    public function configure(): BookFactory
    {
        return $this->afterMaking(function (Book $book) {
            $book->slug = $book->book_code . '-' . Str::slug($book->title);
        });
    }
}
