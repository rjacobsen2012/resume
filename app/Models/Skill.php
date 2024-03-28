<?php

namespace App\Models;

use Database\Factories\SkillFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Skill
 *
 * @property int $id
 * @property int $resume_id
 * @property int $resume_skill_id
 * @property int $years
 * @property int $months
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $name
 * @property-read Resume $resume
 * @property-read ResumeSkill $resumeSkill
 * @property-read string $display
 * @method static SkillFactory factory($count = null, $state = [])
 * @method static Builder|Skill newModelQuery()
 * @method static Builder|Skill newQuery()
 * @method static Builder|Skill query()
 * @method static Builder|Skill whereCreatedAt($value)
 * @method static Builder|Skill whereId($value)
 * @method static Builder|Skill whereMonths($value)
 * @method static Builder|Skill whereResumeId($value)
 * @method static Builder|Skill whereResumeSkillId($value)
 * @method static Builder|Skill whereUpdatedAt($value)
 * @method static Builder|Skill whereYears($value)
 * @mixin Eloquent
 */
class Skill extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'name',
        'display',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    public function resumeSkill(): BelongsTo
    {
        return $this->belongsTo(ResumeSkill::class);
    }

    public function getNameAttribute(): string
    {
        return $this->resumeSkill->name;
    }

    public function getDisplayAttribute()
    {
        $display = $this->name;
        $years = '';
        $months = '';

        if ($this->years) {
            $years = (' ' . $this->years . 'y');
        }

        if ($this->months) {
            $months = (' ' . $this->months . 'm');
        }

        if ($months || $years) {
            $display .= (': ' . $years . $months);
        }

        return $display;
    }
}
