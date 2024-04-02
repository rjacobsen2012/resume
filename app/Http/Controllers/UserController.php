<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserRolesRequest;
use App\Models\Role;
use App\Models\User;
use App\Support\DataTable\UsersDatatable;
use App\Support\ResumeFilesTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    use ResumeFilesTrait;
    use WithFaker;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return Inertia::render('User/Index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $this->setUpFaker();
        $password = $this->faker->password();

        User::create(array_merge($request->validated(), [
            'password' => bcrypt($password),
        ]));

        Password::sendResetLink($request->only('email'));

        return redirect()
            ->route('user.index')
            ->with('status', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return Inertia::render('User/Create');
    }

    /**
     * Display the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', [User::class, $user]);

        return Inertia::render('User/Edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', [User::class, $user]);

        $validated = $request->validated();
        $validated['dark_theme'] = (bool) $validated['dark_theme'];

        $user->fill($request->validated());
        $user->save();

        return redirect()
            ->route('user.edit', [$user->id])
            ->with('status', 'User updated successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUserRoles(UpdateUserRolesRequest $request, User $user)
    {
        $this->authorize('update', [User::class, $user]);

        $requestRoles = Role::whereIn('id', $request->input('roles'))->get();
        $roles = Role::all();
        $message = null;

        foreach ($roles as $role) {
            $found = $requestRoles->where('name', $role->name)->first();

            if (! $found instanceof Role) {
                $user->removeRole($role);
                $message = "Role [$role->name] was removed from [$user->name]";
            } elseif (! $user->hasRole($role)) {
                $user->assignRole($role);
                $message = "Role [$role->name] was assigned to [$user->name]";
            }
        }

        return response()->json([
            'user' => $user,
            'status' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', [User::class, $user]);

        $this->deleteResume($user->resume);
        $user->delete();

        return response()->json([
            'status' => 'User deleted successfully',
        ]);
    }

    public function data(Request $request, UsersDatatable $datatable): JsonResponse
    {
        return $datatable->getDataTable($request);
    }
}
