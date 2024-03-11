<?php

namespace App\Rules;

use App\Models\Resume;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ResumeSearch implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $resume = Resume::byValue($value)->first();

        if (! $resume) {
            $fail("The resume for [$value] was not found.");
        }
    }
}
