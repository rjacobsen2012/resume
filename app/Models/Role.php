<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions, $without = false)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static Builder|Role withoutPermission($permissions)
 *
 * @property-read bool $has_users
 *
 * @mixin Eloquent
 */
class Role extends \Spatie\Permission\Models\Role
{
    protected $appends = [
        'has_users',
    ];

    public function getHasUsersAttribute(): bool
    {
        return User::with('roles')->get()->filter(
                fn (User $user) => $user->roles->where('name', $this->name)->toArray()
            )->count() > 0;
    }
}
