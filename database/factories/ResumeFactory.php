<?php

namespace Database\Factories;

use App\Models\Resume;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Resume>
 */
class ResumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn() => User::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'profile' => $this->faker->url(),
            'linked_in_profile' => $this->faker->url(),
            'github_profile' => $this->faker->url(),
            'phone' => $this->faker->phoneNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
