<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\LibrarianActivity;
use App\Models\Transaction;
use App\Models\User;

class LibrarianActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LibrarianActivity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'librarian_id' => User::factory(),
            'transaction_id' => Transaction::factory(),
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'action' => $this->faker->word(),
        ];
    }
}
