<?php

namespace App\Http\Requests;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRolesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'roles' => [
                'array',
                function (string $attribute, mixed $value, Closure $fail) {
                    foreach ($value as $roleId) {
                        $found = Role::find($roleId);

                        if (! $found) {
                            $fail("The {$attribute} is invalid.");
                        }
                    }
                },
            ],
        ];
    }
}
