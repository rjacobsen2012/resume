<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Example;
use App\Models\Experience;
use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldToNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldResumes = DB::connection('old_mysql')->table('resume_users')->get();

        /** @var ResumeSkill $skill */
        foreach (DB::connection('old_mysql')->table('resume_skills')->get() as $skill) {
            ResumeSkill::firstOrCreate([
                'name' => $skill->name,
            ]);
        }

        /** @var Resume $oldResume */
        foreach ($oldResumes as $oldResume) {
            $email = $oldResume->email;
            $user = User::whereEmail($email)->first();

            $resume = Resume::create([
                'user_id' => $user->id,
                'name' => $oldResume->name,
                'title' => $oldResume->title ?? 'Senior Software Engineer',
                'email' => $oldResume->email,
                'city' => $oldResume->city ?? 'New Albany',
                'state' => $oldResume->state ?? 'Indiana',
                'country' => $oldResume->country ?? 'United States',
                'profile' => $oldResume->profile,
                'linked_in_profile' => $oldResume->linked_in_profile,
                'github_profile' => $oldResume->github_profile,
                'phone' => $oldResume->phone,
            ]);

            /** @var Education $education */
            foreach (DB::connection('old_mysql')->table('resume_educations')->get() as $education) {
                Education::create([
                    'resume_id' => $resume->id,
                    'school' => $education->school,
                    'city' => $education->city,
                    'state' => $education->state,
                    'degree' => $education->degree,
                    'started_at' => $education->started_at,
                    'ended_at' => $education->ended_at,
                    'description' => $education->description,
                ]);
            }

            /** @var Experience $experience */
            foreach (DB::connection('old_mysql')->table('resume_experiences')->get() as $experience) {
                Experience::create([
                    'resume_id' => $resume->id,
                    'company_name' => $experience->company_name,
                    'title' => $experience->title,
                    'city' => $experience->city,
                    'state' => $experience->state,
                    'started_at' => $experience->started_at,
                    'ended_at' => $experience->ended_at,
                    'present' => $experience->present,
                    'description' => $experience->description,
                    'is_hidden' => $experience->hidden,
                ]);
            }

            /** @var Example $example */
            foreach (DB::connection('old_mysql')->table('resume_work_examples')->get() as $example) {
                Example::create([
                    'resume_id' => $resume->id,
                    'url' => $example->url,
                    'title' => $example->title,
                ]);
            }

            /** @var Skill $oldSkill */
            foreach (DB::connection('old_mysql')->table('resume_user_resume_skill')->get() as $oldSkill) {
                $found = ResumeSkill::find($oldSkill->resume_skill_id);

                if ($found) {
                    Skill::create([
                        'resume_id' => $resume->id,
                        'resume_skill_id' => $found->id,
                        'years' => $oldSkill->years,
                        'months' => $oldSkill->months,
                    ]);
                }
            }
        }
    }
}
