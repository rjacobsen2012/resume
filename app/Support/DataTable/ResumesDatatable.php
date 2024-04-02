<?php

namespace App\Support\DataTable;

use App\Models\Resume;
use App\Support\DataTable\Shared\SortTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class ResumesDatatable
{
    use SortTrait;

    protected const ORDER_COLUMNS = [
        'name' => 'resumes.name',
        'email' => 'resumes.email',
        'title' => 'resumes.title',
        'city' => 'resumes.city',
        'state' => 'resumes.state',
        'country' => 'resumes.country',
    ];

    public function __construct(
        protected DataTables $dataTables
    ) {}

    public function getDataTable(Request $request): JsonResponse
    {
        $query = Resume::notHidden();

        if ($search = Arr::get($request->all(), 'search.value')) {
            $query = $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('title', 'like', "%$search%")
                ->orWhere('city', 'like', "%$search%")
                ->orWhere('state', 'like', "%$search%")
                ->orWhere('country', 'like', "%$search%");
        }

        $this->applySort($request, $query, static::ORDER_COLUMNS, 'name', 'asc');

        return $this->dataTables->eloquent($query)
            ->addColumn('name', fn (Resume $resume) => $resume->name)
            ->addColumn('email', fn (Resume $resume) => $resume->email)
            ->addColumn('title', fn (Resume $resume) => $resume->title)
            ->addColumn('city', fn (Resume $resume) => $resume->city)
            ->addColumn('state', fn (Resume $resume) => $resume->state)
            ->addColumn('country', fn (Resume $resume) => $resume->country)
            ->setRowClass(function (Resume $resume) {
                return 'row_' . $resume->id;
            })
            ->setRowAttr([
                'data-row-id' => fn (Resume $resume) => $resume->id,
            ])
            ->rawColumns([
                'name',
                'email',
                'title',
                'city',
                'state',
                'country',
            ])
            ->toJson();
    }
}
