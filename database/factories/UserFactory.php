<?php

namespace Database\Factories;

use App\Models\User;
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
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a subscription plan.
     *
     * @return $this
     */
    public function withSubscription(string|int $priceId = null): static
    {
        return $this->afterCreating(function (User $user) use ($priceId) {
            optional($user->customer)->update(['trial_ends_at' => null]);

            $subscription = $user->subscriptions()->create([
                'name' => 'default',
                'stripe_id' => fake()->unique()->numberBetween(1, 1000),
                'stripe_status' => 'active',
                'trial_ends_at' => null,
                'ends_at' => null,
            ]);

            $subscription->items()->create([
                'stripe_product' => fake()->unique()->numberBetween(1, 1000),
                'stripe_price' => $priceId,
                'stripe_id' => fake()->unique()->numberBetween(1, 1000),
                'quantity' => 1,
            ]);
        });
    }
}
