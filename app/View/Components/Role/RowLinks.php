<?php

namespace App\View\Components\Role;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RowLinks extends Component
{
    /**
     * @param  Role  $role
     */
    public function __construct(public Role $role)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.role.row-links');
    }
}
