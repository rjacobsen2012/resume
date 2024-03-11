<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Support\DataTable\RolesDatatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        return Inertia::render('Spatie/Role/Index', [
            'status' => session('status'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        Role::create($request->validated());

        return redirect()
            ->route('role.index')
            ->with('status', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return Inertia::render('Spatie/Role/Create');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('update', [Role::class, $role]);

        return Inertia::render('Spatie/Role/Edit', [
            'role' => $role,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', [Role::class, $role]);

        $role->fill($request->validated());
        $role->save();

        return redirect()
            ->route('role.edit', [$role->id])
            ->with('status', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', [Role::class, $role]);

        $role->delete();

        return response()->json([
            'status' => 'Role deleted successfully',
        ]);
    }

    public function data(Request $request, RolesDatatable $datatable): JsonResponse
    {
        return $datatable->getDataTable($request);
    }
}
