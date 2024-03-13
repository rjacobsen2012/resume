<?php

namespace Database\Factories;

use App\Models\Education;
use App\Models\Resume;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Education>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resume_id' => fn () => Resume::factory(),
            'school' => $this->faker->name(),
            'city' => 'Louisville',
            'state' => 'KY',
            'degree' => 'Bachelors',
            'started_at' => $start = Carbon::now()->subYears(4),
            'ended_at' => $start->clone()->addYears(4),
            'description' => $this->faker->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
