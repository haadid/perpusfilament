<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Publisher;

class PublisherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Publisher::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $publishers = [
            "Penerbit Mizan",
            "Penerbit Erlangga",
            "Bentang Pustaka",
            "Gramedia Pustaka Utama",
            "Penerbit Buku Kompas",
        ];
        $name = fake()->unique()->randomElement($publishers);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
