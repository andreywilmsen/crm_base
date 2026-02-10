<?php

namespace Modules\Core\Tests\Features\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserResetPasswordTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_reset_password_user()
    {
        $this->loginAsAdmin();

        $user = User::factory()->create([
            'email' => 'andrey@email.com.br'
        ]);

        $user->assignRole('funcionario');

        $response = $this->put(route('user.reset-password', $user));
        $response->assertStatus(302);
        $user->refresh();
        $this->assertTrue(Hash::check('123456', $user->password), 'A senha não foi resetada para o padrão');
    }

    #[Test]
    public function a_funcionario_should_not_be_able_to_reset_passwords()
    {
        $this->loginAsFuncionario();

        $user = User::factory()->create(['password' => Hash::make('senha_intacta')]);

        $response = $this->put(route('user.reset-password', $user));

        $response->assertStatus(403);

        $this->assertTrue(Hash::check('senha_intacta', $user->refresh()->password));
    }

    #[Test]
    public function a_guest_should_not_be_able_to_reset_passwords()
    {
        $user = User::factory()->create();

        $response = $this->put(route('user.reset-password', $user));

        $response->assertRedirect(route('login'));
    }
}
