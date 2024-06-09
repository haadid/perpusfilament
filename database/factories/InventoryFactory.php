<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Inventory;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'slug' => $this->faker->slug(),
            'book_code' => $this->faker->word(),
            'stock' => $this->faker->numberBetween(-10000, 10000),
            'available' => $this->faker->numberBetween(-10000, 10000),
            'borrowed' => $this->faker->numberBetween(-10000, 10000),
            'damaged' => $this->faker->numberBetween(-10000, 10000),
            'lost' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
