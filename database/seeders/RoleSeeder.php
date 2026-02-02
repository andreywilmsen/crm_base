<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Criar as Permissões (Ações que podem ser feitas)
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.delete']);

        // 2. Criar os Perfis (Roles)
        $admin = Role::create(['name' => 'admin']);
        Role::create(['name' => 'funcionario']);

        // 3. Atribuir Permissões aos Perfis
        // Admin ganha tudo
        $admin->givePermissionTo(Permission::all());
    }
}
