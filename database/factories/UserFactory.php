<?php

namespace Database\Factories;

use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
