<?php

namespace App\Models;

use Database\Factories\ExampleFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Example
 *
 * @property int $id
 * @property int $resume_id
 * @property string $url
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Resume $resume
 * @method static ExampleFactory factory($count = null, $state = [])
 * @method static Builder|Example newModelQuery()
 * @method static Builder|Example newQuery()
 * @method static Builder|Example query()
 * @method static Builder|Example whereCreatedAt($value)
 * @method static Builder|Example whereId($value)
 * @method static Builder|Example whereResumeId($value)
 * @method static Builder|Example whereTitle($value)
 * @method static Builder|Example whereUpdatedAt($value)
 * @method static Builder|Example whereUrl($value)
 * @mixin Eloquent
 */
class Example extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
