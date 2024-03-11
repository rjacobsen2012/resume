<?php

namespace App\Models;

use Database\Factories\ExperienceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Experience
 *
 * @property int $id
 * @property int $resume_id
 * @property string $company_name
 * @property string $title
 * @property string $city
 * @property string $state
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property int $present
 * @property string $description
 * @property int $hidden
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Resume $resume
 * @method static ExperienceFactory factory($count = null, $state = [])
 * @method static Builder|Experience newModelQuery()
 * @method static Builder|Experience newQuery()
 * @method static Builder|Experience query()
 * @method static Builder|Experience whereCity($value)
 * @method static Builder|Experience whereCompanyName($value)
 * @method static Builder|Experience whereCreatedAt($value)
 * @method static Builder|Experience whereDescription($value)
 * @method static Builder|Experience whereEndedAt($value)
 * @method static Builder|Experience whereHidden($value)
 * @method static Builder|Experience whereId($value)
 * @method static Builder|Experience wherePresent($value)
 * @method static Builder|Experience whereResumeId($value)
 * @method static Builder|Experience whereStartedAt($value)
 * @method static Builder|Experience whereState($value)
 * @method static Builder|Experience whereTitle($value)
 * @method static Builder|Experience whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Experience extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'present' => 'boolean',
        'hidden' => 'boolean',
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
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
