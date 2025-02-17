<?php

namespace Database\Factories;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\PermissionRole;
use App\Models\Permission;
use App\Models\Role;

class PermissioRroleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PermissionRole::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'permission_id' => Permissions::factory(),
            'role_id' => Roles::factory(),
        ];
    }
}
