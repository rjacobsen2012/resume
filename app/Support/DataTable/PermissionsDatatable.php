<?php

namespace App\Support\DataTable;

use App\Models\Permission;
use App\Support\DataTable\Shared\SortTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class PermissionsDatatable
{
    use SortTrait;

    protected const ORDER_COLUMNS = [
        'id' => 'permissions.id',
        'name' => 'permissions.name',
        'guard_name' => 'permissions.guard_name',
        'created_at' => 'permissions.created_at',
    ];

    public function __construct(
        protected DataTables $dataTables
    ) {}

    public function getDataTable(Request $request): JsonResponse
    {
        $query = Permission::query();

        if ($search = Arr::get($request->all(), 'search.value')) {
            $query = $query->where('name', 'like', "%$search%");
        }

        $this->applySort($request, $query, static::ORDER_COLUMNS, 'name', 'asc');

        return $this->dataTables->eloquent($query)
            ->addColumn('id', fn (Permission $permission) => $permission->id)
            ->addColumn('name', fn (Permission $permission) => $permission->name)
            ->addColumn('guard_name', fn (Permission $permission) => $permission->guard_name)
            ->addColumn('created_at', fn (Permission $permission) => $permission->created_at->format('M d, Y h:i:s A'))
            ->addColumn('permission_id', fn (Permission $permission) => $permission->id)
            ->addColumn('has_users', fn (Permission $permission) => $permission->has_users)
            ->setRowClass(function (Permission $permission) {
                return 'row_' . $permission->id;
            })
            ->setRowAttr([
                'data-row-id' => fn (Permission $permission) => $permission->id
            ])
            ->rawColumns([
                'id',
                'name',
                'guard_name',
                'created_at',
                'permission_id',
            ])
            ->toJson();
    }
}
