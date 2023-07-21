<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ResumeExperience
 * @property Eloquent
 * @package App\Models
 *
 * @property int id
 * @property string company_name
 * @property string title
 * @property string city
 * @property string state
 * @property Carbon started_at
 * @property Carbon ended_at
 * @property string description
 * @property boolean present
 * @property boolean $hidden
 * @property ResumeUser resumeUser
 */
class ResumeExperience extends Model
{
    protected $guarded = ['id'];

    protected $dates = [
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'present' => 'boolean',
        'hidden' => 'boolean',
    ];

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
