<?php

namespace App\Support\DataTable;

use App\Models\User;
use App\Support\DataTable\Shared\SortTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class UsersDatatable
{
    use SortTrait;

    protected const ORDER_COLUMNS = [
        'id' => 'users.id',
        'first_name' => 'users.first_name',
        'last_name' => 'users.last_name',
        'email' => 'users.email',
        'created_at' => 'users.created_at',
    ];

    public function __construct(
        protected DataTables $dataTables
    ) {}

    public function getDataTable(Request $request): JsonResponse
    {
        $query = User::query();

        if ($search = Arr::get($request->all(), 'search.value')) {
            $query = $query->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $this->applySort($request, $query, static::ORDER_COLUMNS, 'name', 'asc');

        return $this->dataTables->eloquent($query)
            ->addColumn('id', fn (User $user) => $user->id)
            ->addColumn('first_name', fn (User $user) => $user->first_name)
            ->addColumn('last_name', fn (User $user) => $user->last_name)
            ->addColumn('email', fn (User $user) => $user->email)
            ->addColumn('created_at', fn (User $user) => $user->created_at->format('M d, Y h:i:s A'))
            ->addColumn('user_id', fn (User $user) => $user->id)
            ->setRowClass(function (User $user) {
                return 'row_' . $user->id;
            })
            ->setRowAttr([
                'data-row-id' => fn (User $user) => $user->id,
            ])
            ->rawColumns([
                'id',
                'first_name',
                'last_name',
                'email',
                'created_at',
                'user_id',
            ])
            ->toJson();
    }
}
