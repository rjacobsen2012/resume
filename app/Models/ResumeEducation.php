<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ResumeEducation
 * @property Eloquent
 * @package App\Models
 *
 * @property int id
 * @property string school
 * @property string city
 * @property string state
 * @property string degree
 * @property Carbon started_at
 * @property Carbon ended_at
 * @property string description
 * @property ResumeUser resumeUser
 */
class ResumeEducation extends Model
{
    protected $guarded = ['id'];

    protected $dates = [
        'started_at',
        'ended_at',
    ];

    protected $table = 'resume_educations';

    /**
     * @return BelongsTo
     */
    public function resumeUser()
    {
        return $this->belongsTo(ResumeUser::class);
    }

    public function getStartedAtAttribute($value)
    {
        if ($value instanceof Carbon) {
            return $value->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getEndedAtAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        if ($value instanceof Carbon) {
            return $value->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }
}
