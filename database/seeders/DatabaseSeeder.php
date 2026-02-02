<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // Primeiro criamos as regras de acesso (Roles/Permissions)
        $this->call([
            RoleSeeder::class,
        ]);

        // Agora criamos o seu usuário administrador
        $user = User::factory()->create([
            'name' => 'Admin Sistema',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // Define uma senha padrão
        ]);

        // Atribui o cargo de admin a este usuário criado
        $user->assignRole('admin');

        // Criar um funcionário de teste para você ver a diferença
        $func = User::factory()->create([
            'name' => 'Funcionario Teste',
            'email' => 'func@admin.com',
            'password' => Hash::make('password'),
        ]);
        
        $func->assignRole('funcionario');
    }
}
