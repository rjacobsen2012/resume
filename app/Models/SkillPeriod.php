<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * One stretch of time a skill was in use. A null `ended_on` means it still is.
 *
 * @property int $id
 * @property int $skill_id
 * @property Carbon $started_on
 * @property Carbon|null $ended_on
 */
class SkillPeriod extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
        ];
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    /**
     * Where this period ends for the purpose of counting time. An open period runs
     * to today, not for ever.
     */
    public function endsOn(): Carbon
    {
        return $this->ended_on ?? Carbon::today();
    }
}
