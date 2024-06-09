<?php

namespace Database\Factories;

use App\Enums\UserAction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ActivityLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'action' => fake()->randomElement(UserAction::cases()),
        ];
    }
}
