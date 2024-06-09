<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\BookEdit;
use App\Models\User;
use App\Models\ValidationBook;

class ValidationBookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ValidationBook::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'user_id' => User::factory(),
            'book_edit_id' => BookEdit::factory(),
            'reason' => $this->faker->text(),
            'requested_at' => $this->faker->dateTime(),
            'validated_at' => $this->faker->dateTime(),
            'type' => $this->faker->word(),
            'status' => $this->faker->word(),
        ];
    }
}
