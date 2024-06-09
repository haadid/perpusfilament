<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LibrarianTransactionActivity;
use App\Models\Transaction;
use App\Models\User;

class LibrarianTransactionActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LibrarianTransactionActivity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'librarian_id' => User::factory(),
            'transaction_id' => Transaction::factory(),
            'action' => $this->faker->word(),
            'timestamp' => $this->faker->word(),
            'user_id' => User::factory(),
        ];
    }
}
