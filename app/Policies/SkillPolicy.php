<?php

namespace App\Policies;

use App\Models\Resume;
use App\Models\Skill;
use App\Models\User;

class SkillPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Resume $resume): bool
    {
        return $resume->user->is($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Resume $resume, Skill $skill): bool
    {
        return $resume->user->is($user) && $skill->resume->is($resume);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Resume $resume): bool
    {
        return $resume->user->is($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resume $resume, Skill $skill): bool
    {
        return $resume->user->is($user) && $skill->resume->is($resume);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resume $resume, Skill $skill): bool
    {
        return $resume->user->is($user) && $skill->resume->is($resume);
    }
}
