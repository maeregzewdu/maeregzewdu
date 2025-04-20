<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'message' => fake()->sentence(),
            'plan' => fake()->randomElement(['Basic', 'Pro', 'Enterprise']),
            'status' => fake()->randomElement(['new', 'contacted', 'qualified', 'converted', 'rejected', 'lost']),
            'source' => fake()->randomElement(['Website Form', 'Social Media', 'Referral', 'Email Campaign', 'Phone Call', 'Walk-in']),
            'ip_address' => fake()->ipv4(),
            'note' => fake()->sentence(),
        ];
    }
}
