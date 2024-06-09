<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'requested_at' => $this->faker->dateTime(),
            'borrowed_at' => $this->faker->dateTime(),
            'due_at' => $this->faker->dateTime(),
            'returned_at' => $this->faker->dateTime(),
            'status' => $this->faker->word(),
            'type' => $this->faker->word(),
            'reason' => $this->faker->text(),
            'original_transaction_id' => Transaction::factory(),
            'transaction_id' => Transaction::factory(),
        ];
    }
}
