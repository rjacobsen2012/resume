<?php

namespace App\Policies;

use App\Models\Experience;
use App\Models\Resume;
use App\Models\User;

class ExperiencePolicy
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
    public function view(User $user, Resume $resume, Experience $experience): bool
    {
        return $resume->user->is($user) && $experience->resume->is($resume);
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
    public function update(User $user, Resume $resume, Experience $experience): bool
    {
        return $resume->user->is($user) && $experience->resume->is($resume);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resume $resume, Experience $experience): bool
    {
        return $resume->user->is($user) && $experience->resume->is($resume);
    }
}
