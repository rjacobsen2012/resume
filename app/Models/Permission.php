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
 * @property-read Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission permission($permissions, $without = false)
 * @method static Builder|Permission query()
 * @method static Builder|Permission role($roles, $guard = null, $without = false)
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereGuardName($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @method static Builder|Permission withoutPermission($permissions)
 * @method static Builder|Permission withoutRole($roles, $guard = null)
 *
 * @property-read bool $belongs_to_role
 * @property-read bool $has_users
 *
 * @mixin Eloquent
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    protected $appends = [
        'has_users',
        'belongs_to_role',
    ];

    public function getHasUsersAttribute(): bool
    {
        return User::with('permissions')->get()->filter(
            fn (User $user) => $user->permissions->where('name', $this->name)->toArray()
        )->count() > 0;
    }

    public function getBelongsToRoleAttribute(): bool
    {
        return $this->roles->count() > 0;
    }
}
