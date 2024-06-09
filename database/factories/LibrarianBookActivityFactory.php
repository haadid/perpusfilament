<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\LibrarianBookActivity;
use App\Models\User;

class LibrarianBookActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LibrarianBookActivity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'librarian_id' => User::factory(),
            'book_id' => Book::factory(),
            'action' => $this->faker->word(),
            'timestamp' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
