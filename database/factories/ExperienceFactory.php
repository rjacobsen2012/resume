<?php

namespace Database\Factories;

use App\Cryptos\Encryptors\ExperienceEncryptor;
use App\Models\Experience;
use App\Models\Resume;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return app(ExperienceEncryptor::class)->encrypt([
            'resume_id' => fn() => Resume::factory(),
            'company_name' => $this->faker->company(),
            'title' => $this->faker->title(),
            'city' => 'Louisville',
            'state' => 'KY',
            'started_at' => $start = Carbon::now()->subYears(4),
            'ended_at' => $start->clone()->addYears(4),
            'description' => $this->faker->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
