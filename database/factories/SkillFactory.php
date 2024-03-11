<?php

namespace Database\Factories;

use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resume_id' => fn() => Resume::factory(),
            'resume_skill_id' => fn() => ResumeSkill::factory(),
            'years' => 4,
            'months' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
