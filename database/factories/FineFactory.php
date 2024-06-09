<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Fine;
use App\Models\User;

class FineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fine::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'issued_at' => $this->faker->dateTime(),
            'amount' => $this->faker->randomFloat(2, 0, 9999999999.99),
            'is_paid' => $this->faker->boolean(),
            'paid_at' => $this->faker->dateTime(),
            'reason' => $this->faker->text(),
            'original_fine_id' => Fine::factory(),
        ];
    }
}
