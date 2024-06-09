<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $categories = [
            "Novel",
            "Komik",
            "Resep Masakan",
            "Semua Umur",
            "Khusus Dewasa",
        ];
        $name = fake()->unique()->randomElement($categories);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
