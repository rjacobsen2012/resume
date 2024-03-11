<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\Resume;
use App\Models\User;

class EducationPolicy
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
    public function view(User $user, Resume $resume, Education $education): bool
    {
        return $resume->user->is($user) && $education->resume->is($resume);
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
    public function update(User $user, Resume $resume, Education $education): bool
    {
        return $resume->user->is($user) && $education->resume->is($resume);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resume $resume, Education $education): bool
    {
        return $resume->user->is($user) && $education->resume->is($resume);
    }
}
