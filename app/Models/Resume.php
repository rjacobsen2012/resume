<?php

namespace App\Models;

use App\Constant\TailwindCustom;
use Database\Factories\ResumeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Resume
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $profile
 * @property string $linked_in_profile
 * @property string $github_profile
 * @property string $phone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Education> $educations
 * @property-read int|null $educations_count
 * @property-read Collection<int, Example> $examples
 * @property-read int|null $examples_count
 * @property-read Collection<int, Experience> $experiences
 * @property-read int|null $experiences_count
 * @property-read Collection<int, Skill> $skills
 * @property-read int|null $skills_count
 * @property-read User $user
 * @method static ResumeFactory factory($count = null, $state = [])
 * @method static Builder|Resume newModelQuery()
 * @method static Builder|Resume newQuery()
 * @method static Builder|Resume query()
 * @method static Builder|Resume whereCreatedAt($value)
 * @method static Builder|Resume whereEmail($value)
 * @method static Builder|Resume whereGithubProfile($value)
 * @method static Builder|Resume whereId($value)
 * @method static Builder|Resume whereLinkedInProfile($value)
 * @method static Builder|Resume whereName($value)
 * @method static Builder|Resume wherePhone($value)
 * @method static Builder|Resume whereProfile($value)
 * @method static Builder|Resume whereUpdatedAt($value)
 * @method static Builder|Resume whereUserId($value)
 * @property-read string|null $pdf
 * @property-read string|null $pdf_link
 * @property-read string|null $word
 * @property-read string|null $word_link
 * @method static Builder|Resume byValue(string $value)
 * @property int $hidden
 * @method static Builder|Resume whereHidden($value)
 * @method static Builder|Resume notHidden()
 * @property-read string $bg_color
 * @mixin Eloquent
 */
class Resume extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'pdf',
        'word',
        'pdf_link',
        'word_link',
        'bg_color',
    ];

    protected $with = [
        'user',
        'skills',
        'experiences',
        'educations',
        'examples',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function examples(): HasMany
    {
        return $this->hasMany(Example::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function getPdfAttribute(): ?string
    {
        $resumeName = config('resume.file');
        $file = asset("storage/$resumeName.pdf") ?? null;
        return file_exists(storage_path("app/public/$resumeName.pdf")) ? "$resumeName.pdf" : null;
    }

    public function getPdfLinkAttribute(): ?string
    {
        $resumeName = config('resume.file');
        $file = asset("storage/$resumeName.pdf") ?? null;
        return file_exists(storage_path("app/public/$resumeName.pdf")) ? $file : null;
    }

    public function getWordAttribute(): ?string
    {
        $resumeName = config('resume.file');
        return file_exists(storage_path("app/public/$resumeName.docx")) ? "$resumeName.docx" : null;
    }

    public function getWordLinkAttribute(): ?string
    {
        $resumeName = config('resume.file');
        $file = asset("storage/$resumeName.docx") ?? null;
        return file_exists(storage_path("app/public/$resumeName.docx")) ? $file : null;
    }

    public function scopeByValue(Builder $query, string $value): void
    {
        $query->where('email', 'like', $value)
            ->orWhere('id', (int) $value);
    }

    public function scopeNotHidden(Builder $query): void
    {
        $query->where('hidden', '=', false);
    }

    public function accessible(User $user): bool
    {
        return $this->user->id === $user->id || ! $this->hidden;
    }

    public function getBgColorAttribute(): string
    {
        return TailwindCustom::randomBgColor();
    }
}
