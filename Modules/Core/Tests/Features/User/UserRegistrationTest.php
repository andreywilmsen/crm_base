<?php

namespace Modules\Core\Tests\Features\User;

use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function a_guest_should_not_be_able_to_access_registration()
    {
        $response = $this->post(route('user.store'), []);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function a_funcionario_should_not_be_able_to_register_user()
    {
        $this->loginAsFuncionario();

        $user = [
            'name' => 'Tentativa Invasor',
            'email' => 'invasor@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => 'invasor@email.com']);
    }

    #[Test]
    public function it_should_block_register_user_with_short_name()
    {
        $this->loginAsAdmin();

        $user = [
            'name' => 'An',
            'email' => 'andrey@email.com',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    #[Test]
    public function it_should_register_user()
    {
        $this->loginAsAdmin();

        $user = [
            'name' => 'Andrey Wilmsen de Paula',
            'email' => 'andrey@email.com.br',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'rememberToken' => null,
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'andrey@email.com.br'
        ]);
    }

    #[Test]
    public function it_should_block_resgiter_user_with_empty_name()
    {
        $this->loginAsAdmin();

        $user = [
            'name' => '',
            'email' => 'andrey@email.com.br',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'rememberToken' => null,
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users', [
            'email' => 'andrey@email.com.br'
        ]);
    }

    #[Test]
    public function it_should_block_register_user_with_empty_email()
    {
        $this->loginAsAdmin();

        $user = [
            'name' => 'Andrey Wilmsen',
            'email' => '',
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'rememberToken' => null,
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users', [
            'email' => 'andrey@email.com.br'
        ]);
    }

    #[Test]
    public function it_should_block_register_user_with_registered_email()
    {
        $this->loginAsAdmin();
        $emailExistente = 'ja_existe@email.com';

        UserModel::factory()->create(['email' => $emailExistente]);

        $user = [
            'name' => 'Novo Usuario',
            'email' => $emailExistente,
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin',
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
        $this->assertCount(1, UserModel::where('email', $emailExistente)->get());
    }

    #[Test]
    public function it_should_block_register_user_with_password_empty()
    {
        $this->loginAsAdmin();

        $user = [
            'name' => 'Andrey Wilmsen',
            'email' => 'andrey@email.com',
            'password' => '',
            'password_confirmation' => 'adminadmin',
            'rememberToken' => null,
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseMissing('users', ['email' => 'andrey@email.com']);
    }

    #[Test]
    public function it_should_block_register_user_with_password_nots_match()
    {
        $this->loginAsAdmin();

        $user = [
            'name' => 'Andrey Wilmsen',
            'email' => 'andrey@teste.com',
            'password' => 'adminadmin',
            'password_confirmation' => 'andrey',
            'rememberToken' => null,
            'role' => 'admin'
        ];

        $response = $this->post(route('user.store'), $user);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseMissing('users', ['email' => 'andrey@teste.com']);
    }
}
