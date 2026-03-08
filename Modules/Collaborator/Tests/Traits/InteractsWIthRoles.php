<?php

namespace Modules\Record\Tests\Traits;

use App\Models\User as UserModel;
use Spatie\Permission\Models\Role;

trait InteractsWithRoles
{
    protected function setupRoles(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'funcionario', 'guard_name' => 'web']);
    }

    protected function loginAsAdmin(): UserModel
    {
        $this->setupRoles();
        $admin = UserModel::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin);

        return $admin;
    }

    protected function loginAsFuncionario(): UserModel
    {
        $this->setupRoles();
        $funcionario = UserModel::factory()->create();
        $funcionario->assignRole('funcionario');
        $this->actingAs($funcionario);

        return $funcionario;
    }
}
