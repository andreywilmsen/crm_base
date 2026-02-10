<?php

namespace Modules\Core\Tests\Features\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserGetTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function a_guest_not_be_able_get_user()
    {
        Role::create(['name' => 'funcionario']);

        $user = User::factory()->create([
            'email' => 'andrey@email.com.br'
        ]);

        $user->assignRole('funcionario');

        $response = $this->get(route('user.show', $user));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function a_funcionario_not_be_able_get_user(){
        $this->loginAsFuncionario();

        $user = User::factory()->create([
            'email' => 'andrey@email.com.br'
        ]);

        $user->assignRole('funcionario');

        $response = $this->get(route('user.show', $user));
        $response->assertStatus(403);
    }

    #[Test]
    public function it_should_get_user()
    {
        $this->loginAsAdmin();

        $user = User::factory()->create([
            'email' => 'andrey@email.com.br'
        ]);

        $user->assignRole('funcionario');

        $response = $this->get(route('user.show', $user));
        $response->assertStatus(200);
        $response->assertSee('andrey@email.com.br');
    }

    #[Test]
    public function it_should_return_404_if_user_not_found(){
        $this->loginAsAdmin();

        $response = $this->get(route('user.show', 99999));
        $response->assertStatus(404);
    }
}
