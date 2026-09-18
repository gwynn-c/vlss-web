<?php

namespace Database\Factories;

use App\Models\ContactSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
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
            'company' => fake()->optional()->company(),
            'email' => fake()->safeEmail(),
            'topic' => fake()->randomElement(['Co-development', 'Original project / publishing', 'Prototype or proof of concept', 'Press', 'Joining the team', 'Something else']),
            'budget' => fake()->randomElement(['Not sure yet', 'Under $10k', '$10k – $50k', '$50k – $150k', '$150k+']),
            'message' => fake()->paragraph(),
            'ip_address' => fake()->ipv4(),
        ];
    }
}
