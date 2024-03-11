<?php

namespace App\Support\DataTable;

use App\Models\Role;
use App\Support\DataTable\Shared\SortTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class RolesDatatable
{
    use SortTrait;

    protected const ORDER_COLUMNS = [
        'id' => 'roles.id',
        'name' => 'roles.name',
        'guard_name' => 'roles.guard_name',
        'created_at' => 'roles.created_at',
    ];

    public function __construct(
        protected DataTables $dataTables
    ) {}

    public function getDataTable(Request $request): JsonResponse
    {
        $query = Role::query();

        if ($search = Arr::get($request->all(), 'search.value')) {
            $query = $query->where('name', 'like', "%$search%");
        }

        $this->applySort($request, $query, static::ORDER_COLUMNS, 'name', 'asc');

        return $this->dataTables->eloquent($query)
            ->addColumn('id', fn (Role $role) => $role->id)
            ->addColumn('name', fn (Role $role) => $role->name)
            ->addColumn('guard_name', fn (Role $role) => $role->guard_name)
            ->addColumn('created_at', fn (Role $role) => $role->created_at->format('M d, Y h:i:s A'))
            ->addColumn('role_id', fn (Role $role) => $role->id)
            ->addColumn('has_users', fn (Role $role) => $role->has_users)
            ->setRowClass(function (Role $role) {
                return 'row_' . $role->id;
            })
            ->setRowAttr([
                'data-row-id' => fn (Role $role) => $role->id
            ])
            ->rawColumns([
                'id',
                'name',
                'guard_name',
                'created_at',
                'role_id',
            ])
            ->toJson();
    }
}
