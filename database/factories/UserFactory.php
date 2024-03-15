<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->name;
        $nameParts = explode(' ', $name);

        return [
            'name' => $nameParts[0] . ' ' . end($nameParts), // ชื่อ + นามสกุล
            'student_id' => $this->faker->numberBetween(1000000000, 9999999999),
            'branch_id' => $this->faker->numberBetween(1, 4),
            'year_id' => $this->faker->numberBetween(1, 4),
            'phone_number' => $this->faker->numberBetween(1000000000, 9999999999),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
