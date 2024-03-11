<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Example;
use App\Models\Experience;
use App\Models\Resume;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class ResumesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding resumes...');
        for ($i = 0; $i < 20; $i++) {
            $resume = Resume::factory()->create();
            $this->command->info('Seeding resume data...');

            for ($j = 0; $j < 10; $j++) {
                Skill::factory()->create(['resume_id' => $resume->id]);
            }

            for ($j = 0; $j < 2; $j++) {
                Education::factory()->create(['resume_id' => $resume->id]);
            }

            for ($j = 0; $j < 2; $j++) {
                Example::factory()->create(['resume_id' => $resume->id]);
            }

            for ($j = 0; $j < 4; $j++) {
                Experience::factory()->create(['resume_id' => $resume->id]);
            }
        }
    }
}
