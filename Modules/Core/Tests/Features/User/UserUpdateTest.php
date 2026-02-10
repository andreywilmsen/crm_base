<?php

namespace Modules\Core\Tests\Features\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function a_guest_should_not_be_able_to_access_update()
    {
        $response = $this->put(route('user.update', ['id' => 2]), []);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function a_funcionario_should_not_be_able_to_update_user()
    {

        $this->loginAsFuncionario();

        $user = [
            'name' => 'Andrey Wilmsen de Paula',
            'email' => 'andrey@email.com',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'admin'
        ];

        $response = $this->put(route('user.update', ['id' => 4]), $user);

        $response->assertStatus(403);
    }

    #[Test]
    public function it_should_block_update_user_with_short_name()
    {
        $this->loginAsAdmin();

        $userToUpdate = User::factory()->create();

        $user = [
            'name' => 'An',
            'email' => 'andrey@email.com.br',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'admin'
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $user);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    #[Test]
    public function it_should_update_user()
    {
        $this->loginAsAdmin();

        $userToUpdate = User::factory()->create([
            'email' => 'velho@email.com.br'
        ]);
        $userToUpdate->assignRole('funcionario');

        $user = [
            'name' => 'Andrey Wilmsen de Paula',
            'email' => 'novo@email.com.br',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'admin'
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $user);

        $response->assertStatus(302);
        $response->assertRedirect(route('user.index'));
    }

    #[Test]
    public function it_should_block_update_user_with_empty_name()
    {
        $this->loginAsAdmin();

        $userToUpdate = User::factory()->create([
            'email' => 'velho@email.com.br'
        ]);
        $userToUpdate->assignRole('funcionario');

        $user = [
            'name' => '',
            'email' => 'novo@email.com.br',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'admin'
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    #[Test]
    public function it_should_block_update_user_with_empty_email()
    {
        $this->loginAsAdmin();

        $userToUpdate = User::factory()->create([
            'email' => 'velho@email.com.br'
        ]);

        $userToUpdate->assignRole('funcionario');

        $user = [
            'name' => 'Andrey Wilmsen de Paula',
            'email' => '',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'admin'
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function it_should_block_update_user_with_empty_role()
    {
        $this->loginAsAdmin();

        $userToUpdate = User::factory()->create([
            'email' => 'velho@email.com.br'
        ]);

        $userToUpdate->assignRole('funcionario');

        $user = [
            'name' => 'Andrey Wilmsen de Paula',
            'email' => 'novo@email.com.br',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => ''
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['role']);
    }

    #[Test]
    public function it_should_not_allow_duplicate_email_on_update()
    {
        $this->loginAsAdmin();

        $userA = User::factory()->create(['email' => 'userA@email.com']);
        $userA->assignRole('funcionario');

        $userB = User::factory()->create(['email' => 'userB@email.com']);

        $userUpdateData = [
            'name' => 'Andrey Update',
            'email' => 'userB@email.com',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'funcionario'
        ];

        $response = $this->put(route('user.update', $userA->id), $userUpdateData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function it_should_allow_updating_without_changing_email()
    {
        $this->loginAsAdmin();

        $user = User::factory()->create(['email' => 'manter@email.com']);
        $user->assignRole('funcionario');

        $userUpdateData = [
            'name' => 'Novo Nome Mas Mesmo Email',
            'email' => 'manter@email.com',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'funcionario'
        ];

        $response = $this->put(route('user.update', $user->id), $userUpdateData);

        $response->assertStatus(302);
        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseHas('users', ['name' => 'Novo Nome Mas Mesmo Email']);
    }

    #[Test]
    public function it_should_block_update_if_passwords_do_not_match()
    {
        $this->loginAsAdmin();

        $userToUpdate = User::factory()->create();
        $userToUpdate->assignRole('funcionario');

        $user = [
            'name' => 'Andrey Paula',
            'email' => 'novo@email.com.br',
            'password' => 'senha123',
            'password_confirmation' => 'outra_senha_diferente',
            'role' => 'admin'
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password']);
    }
}
