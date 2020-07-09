<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class ResumeUser
 * @mixin Eloquent
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string profile
 * @property string phone
 * @property string github_profile
 * @property string linked_in_profile
 * @property Collection|ResumeSkill[] resumeSkills
 * @property Collection|ResumeExperience[] resumeExperiences
 * @property Collection|ResumeWorkExample[] resumeWorkExamples
 */
class ResumeUser extends Model
{
    protected $guarded = ['id'];

    /**
     * @return BelongsToMany
     */
    public function resumeSkills()
    {
        return $this->belongsToMany(ResumeSkill::class, 'resume_user_resume_skill')
            ->withPivot(['years', 'months'])
            ->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function resumeExperiences()
    {
        return $this->hasMany(ResumeExperience::class);
    }

    /**
     * @return HasMany
     */
    public function resumeWorkExamples()
    {
        return $this->hasMany(ResumeWorkExample::class);
    }
}
