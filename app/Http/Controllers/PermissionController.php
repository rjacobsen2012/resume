<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Support\DataTable\PermissionsDatatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Permission::class);

        return Inertia::render('Spatie/Permission/Index', [
            'status' => session('status'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $this->authorize('create', Permission::class);

        Permission::create($request->validated());

        return redirect()
            ->route('permission.index')
            ->with('status', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        return Inertia::render('Spatie/Permission/Create');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Permission $permission)
    {
        $this->authorize('update', [Permission::class, $permission]);

        return Inertia::render('Spatie/Permission/Edit', [
            'permission' => $permission,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->authorize('update', [Permission::class, $permission]);

        $permission->fill($request->validated());
        $permission->save();

        return redirect()
            ->route('permission.edit', [$permission->id])
            ->with('status', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', [Permission::class, $permission]);

        $permission->delete();

        return response()->json([
            'status' => 'Permission deleted successfully',
        ]);
    }

    public function data(Request $request, PermissionsDatatable $datatable): JsonResponse
    {
        return $datatable->getDataTable($request);
    }
}
