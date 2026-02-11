<?php

namespace Modules\Core\Tests\Features\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountUpdateUser extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_redirect_unauthenticated_user_to_login()
    {
        $victim = \App\Models\User::factory()->create([
            'name' => 'Vítima',
            'email' => 'vitima@sistema.com'
        ]);

        $data = [
            'name' => 'Hacker Name',
            'email' => 'hacker@sistema.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ];

        $response = $this->put(route('account.update'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $victim->refresh();
        $this->assertEquals('Vítima', $victim->name);
        $this->assertEquals('vitima@sistema.com', $victim->email);
    }

    #[Test]
    public function it_should_update_user()
    {
        $user = $this->loginAsFuncionario();
        $oldPassword = $user->password;
        $data = [
            'name' => 'Andrey Wilmsen de Paula',
            'email' => $user->email,
            'password' => 'adminadmin',
            'password_confirmation' => 'adminadmin'
        ];

        $response = $this->put(route('account.update'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('account.index'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Andrey Wilmsen de Paula', $user->name);
        $this->assertNotEquals($oldPassword, $user->password);
    }

    #[Test]
    public function it_should_update_user_with_empty_password()
    {
        $user = $this->loginAsFuncionario();
        $oldPassword = $user->password;
        $data = [
            'name' => 'Andrey Wilmsen de Paula',
            'email' => $user->email
        ];

        $response = $this->put(route('account.update'), $data);
        $user->refresh();
        $response->assertStatus(302);
        $response->assertRedirect(route('account.index'));
        $this->assertEquals($oldPassword, $user->password);
    }

    #[Test]
    public function it_should_return_error_message_when_update_fails()
    {
        $this->loginAsFuncionario();

        $this->mock(\Modules\Core\Application\Account\UseCases\UpdateUser::class, function ($mock) {
            $mock->shouldReceive('execute')->andThrow(new \Exception('Erro inesperado'));
        });

        $response = $this->put(route('account.update'), [
            'name' => 'Teste',
            'email' => 'teste@email.com'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
