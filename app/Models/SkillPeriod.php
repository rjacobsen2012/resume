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
        // ⚠️ `date:Y-m-d`, not `date`. A plain date cast serialises as
        // "2003-10-27T00:00:00.000000Z", which an <input type="date"> cannot accept
        // and which broke the editor's formatter outright. These are calendar days,
        // not instants, so the time was never meaningful.
        return [
            'started_on' => 'date:Y-m-d',
            'ended_on' => 'date:Y-m-d',
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
