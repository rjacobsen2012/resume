<?php

namespace App\Support\DataTable\Shared;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait SortTrait
{
    protected function applySort(
        Request $request,
        Builder $query,
        array $columns,
        $defaultColumn,
        $defaultDirection = 'desc'
    ): void {
        $sortBy = $request->get('sort_column') ?? $defaultColumn;

        if ($sortBy && in_array($sortBy, array_keys($columns))) {
            $query->orderBy(
                $columns[$sortBy],
                $request->get('sort_direction', $defaultDirection)
            );
        }
    }
}
