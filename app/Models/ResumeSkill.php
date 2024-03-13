<?php

namespace App\Models;

use Database\Factories\ResumeSkillFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ResumeSkill
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|null $resume_users_count
 *
 * @method static Builder|ResumeSkill newModelQuery()
 * @method static Builder|ResumeSkill newQuery()
 * @method static Builder|ResumeSkill query()
 * @method static Builder|ResumeSkill whereCreatedAt($value)
 * @method static Builder|ResumeSkill whereId($value)
 * @method static Builder|ResumeSkill whereName($value)
 * @method static Builder|ResumeSkill whereUpdatedAt($value)
 * @method static ResumeSkillFactory factory($count = null, $state = [])
 *
 * @mixin Eloquent
 */
class ResumeSkill extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
