<?php

namespace App\Models;

use Database\Factories\EducationFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Education
 *
 * @property-read Resume|null $resume
 *
 * @method static EducationFactory factory($count = null, $state = [])
 * @method static Builder|Education newModelQuery()
 * @method static Builder|Education newQuery()
 * @method static Builder|Education query()
 *
 * @property int $id
 * @property int $resume_id
 * @property string $school
 * @property string $city
 * @property string $state
 * @property string|null $degree
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Education whereCity($value)
 * @method static Builder|Education whereCreatedAt($value)
 * @method static Builder|Education whereDegree($value)
 * @method static Builder|Education whereDescription($value)
 * @method static Builder|Education whereEndedAt($value)
 * @method static Builder|Education whereId($value)
 * @method static Builder|Education whereResumeId($value)
 * @method static Builder|Education whereSchool($value)
 * @method static Builder|Education whereStartedAt($value)
 * @method static Builder|Education whereState($value)
 * @method static Builder|Education whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $guarded = ['id'];

    protected $casts = [
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
        if (! $value) {
            return $value;
        }

        if ($value instanceof Carbon) {
            return $value->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }
}
