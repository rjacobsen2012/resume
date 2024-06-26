<?php

namespace App\Models;

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
 * @property Collection<int, Education> $educations
 * @property-read int|null $educations_count
 * @property Collection<int, Example> $examples
 * @property-read int|null $examples_count
 * @property Collection<int, Experience> $experiences
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
 * @property int $is_hidden
 * @method static Builder|Resume whereIsHidden($value)
 * @method static Builder|Resume notHidden()
 * @property string|null $word_resume
 * @property string|null $pdf_resume
 * @method static Builder|Resume wherePdfResume($value)
 * @method static Builder|Resume whereWordResume($value)
 * @property string $title
 * @property string $city
 * @property string $state
 * @property string $country
 * @method static Builder|Resume whereCity($value)
 * @method static Builder|Resume whereCountry($value)
 * @method static Builder|Resume whereState($value)
 * @method static Builder|Resume whereTitle($value)
 * @method static Builder|Resume userSubscribed()
 * @property-read string|null $gravatar
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
        'gravatar',
    ];

    protected $with = [
        'user',
    ];

    protected function casts(): array
    {
        return [
            'is_hidden' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class)->orderBy('started_at', 'desc');
    }

    public function examples(): HasMany
    {
        return $this->hasMany(Example::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class)->orderBy('started_at', 'desc');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function getPdfAttribute(): ?string
    {
        return $this->resumeFile($this->pdf_resume);
    }

    public function getPdfLinkAttribute(): ?string
    {
        return $this->resumeFile($this->pdf_resume);
    }

    protected function resumeFile(?string $fileName = null): ?string
    {
        if (! $fileName) {
            return null;
        }

        $resume = asset("storage/user/$this->user_id/$fileName") ?? null;

        return $resume && file_exists(public_path($resume)) ? $resume : null;
    }

    public function getWordAttribute(): ?string
    {
        return $this->resumeFile($this->word_resume);
    }

    public function getWordLinkAttribute(): ?string
    {
        return $this->resumeFile($this->word_resume);
    }

    public function scopeByValue(Builder $query, string $value): void
    {
        $query->where('email', 'like', $value)
            ->orWhere('id', (int) $value);
    }

    public function scopeNotHidden(Builder $query): void
    {
        $user = auth()->user();
        $query->where('is_hidden', '=', false)
            ->orWhere(function (Builder $query) use ($user) {
                $query->when($user, function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            });
    }

    public function accessible(?User $user = null): bool
    {
        $user = $user ?: auth()->user();

        if ($user?->id === $this->user->id) {
            return true;
        }

        return ! $this->is_hidden;
    }

    public function getGravatarAttribute(): ?string
    {
        return $this->user->gravatar;
    }
}
