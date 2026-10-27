<?php

namespace App\Models;

use App\Support\SkillDuration;
use Database\Factories\SkillFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 *
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
 *
 * @mixin Eloquent
 */
class Skill extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'name',
        'display',
        'totals',
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

    /**
     * Every stretch of time this skill was in use. A period with no end date is
     * still running.
     *
     * @return HasMany<SkillPeriod, $this>
     */
    public function periods(): HasMany
    {
        return $this->hasMany(SkillPeriod::class)->orderBy('started_on');
    }

    /**
     * Total time using this skill, in days, with overlapping periods merged.
     */
    /**
     * @return array{months: int, days: int}
     */
    public function getTotalsAttribute(): array
    {
        return SkillDuration::totals($this->periods);
    }

    /**
     * The pill: "php: 23y".
     *
     * ⚠️ Derived from the PERIODS now, not from the years/months columns. Those
     * columns still exist so a bad backfill stays recoverable, but nothing reads
     * them. A skill with no periods shows just its name, exactly as a skill with
     * zero years and months always did.
     */
    public function getDisplayAttribute(): string
    {
        $label = SkillDuration::label($this->totals);

        return $label === '' ? $this->name : $this->name.': '.$label;
    }
}
