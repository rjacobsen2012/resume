<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class SkillNotExistsOnResume implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $resumeSkills = request()->route('resume')->skills->toArray();

        if (in_array($value, $resumeSkills)) {
            $fail("The $value skill is already on this resume.");
        }
    }
}
