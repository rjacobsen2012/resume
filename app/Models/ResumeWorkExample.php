<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ResumeExperience
 * @property Eloquent
 * @package App\Models
 *
 * @property int id
 * @property string url
 * @property string title
 * @property ResumeUser resumeUser
 */
class ResumeWorkExample extends Model
{
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function resumeUser()
    {
        return $this->belongsTo(ResumeUser::class);
    }
}
