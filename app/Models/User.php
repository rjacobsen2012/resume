<?php

namespace App\Models;

use App\Constant\Roles;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Subscription;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spark\Billable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property string|null $profile_photo_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $gravatar
 * @property-read string $name
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read string $profile_photo_url
 * @property-read Resume|null $resume
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProfilePhotoPath($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereTwoFactorConfirmedAt($value)
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @method static Builder|User whereUpdatedAt($value)
 *
 * @property-read Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 *
 * @method static Builder|User permission($permissions, $without = false)
 * @method static Builder|User role($roles, $guard = null, $without = false)
 * @method static Builder|User withoutPermission($permissions)
 * @method static Builder|User withoutRole($roles, $guard = null)
 *
 * @property-read bool $is_admin
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $pm_expiration
 * @property string|null $extra_billing_information
 * @property string|null $trial_ends_at
 * @property string|null $billing_address
 * @property string|null $billing_address_line_2
 * @property string|null $billing_city
 * @property string|null $billing_state
 * @property string|null $billing_postal_code
 * @property string|null $vat_id
 * @property array $invoice_emails
 * @property string|null $billing_country
 * @property-read Collection<int, Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 *
 * @method static Builder|User hasExpiredGenericTrial()
 * @method static Builder|User onGenericTrial()
 * @method static Builder|User whereBillingAddress($value)
 * @method static Builder|User whereBillingAddressLine2($value)
 * @method static Builder|User whereBillingCity($value)
 * @method static Builder|User whereBillingCountry($value)
 * @method static Builder|User whereBillingPostalCode($value)
 * @method static Builder|User whereBillingState($value)
 * @method static Builder|User whereExtraBillingInformation($value)
 * @method static Builder|User whereInvoiceEmails($value)
 * @method static Builder|User wherePmExpiration($value)
 * @method static Builder|User wherePmLastFour($value)
 * @method static Builder|User wherePmType($value)
 * @method static Builder|User whereStripeId($value)
 * @method static Builder|User whereTrialEndsAt($value)
 * @method static Builder|User whereVatId($value)
 * @property bool $dark_theme
 * @method static Builder|User whereDarkTheme($value)
 * @property-read bool $is_on_trial
 * @property-read bool $is_subscribed
 * @method static Builder|User hasSubscription()
 *
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use Billable;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dark_theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'stripe_id',
        'extra_billing_information',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'name',
        'gravatar',
        'is_admin',
        'is_on_trial',
        'is_subscribed',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'dark_theme' => 'boolean',
            'trial_ends_at' => 'datetime',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getGravatarAttribute(): string
    {
        return 'https://secure.gravatar.com/avatar/' . md5($this->email) . '?size=112';
    }

    protected function validateGravatar($email): bool
    {
        // Craft a potential url and test its headers
        $hash = md5(strtolower(trim($email)));

        $uri = 'https://www.gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);

        if (! str_contains($headers[0], "200")) {
            $has_valid_avatar = false;
        } else {
            $has_valid_avatar = true;
        }

        return $has_valid_avatar;
    }

    public function resume(): HasOne
    {
        return $this->hasOne(Resume::class);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole(Roles::ADMINISTRATOR);
    }

    public function getIsOnTrialAttribute(): bool
    {
        return $this->onTrial();
    }

    public function getIsSubscribedAttribute(): bool
    {
        return $this->subscribed();
    }

    public function scopeHasSubscription(Builder $query): void
    {
        $query->has('subscriptions');
    }
}
