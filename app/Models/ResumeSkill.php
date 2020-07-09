<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class ResumeSkill
 * @mixin Eloquent
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property Collection|ResumeUser[] resumeUsers
 */
class ResumeSkill extends Model
{
    protected $guarded = ['id'];

    /**
     * @return BelongsToMany
     */
    public function resumeUsers()
    {
        return $this->belongsToMany(ResumeUser::class, 'resume_user_resume_skill')
            ->withPivot(['years', 'months'])
            ->withTimestamps();
    }
}
