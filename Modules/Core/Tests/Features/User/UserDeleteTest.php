<?php

namespace Modules\Core\Tests\Features\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function a_guest_should_not_be_able_to_access_delete()
    {
        $user = User::factory()->create();
        $response = $this->delete(route('user.destroy', $user));
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function a_funcionario_should_not_be_able_to_delete_user()
    {
        $this->loginAsFuncionario();

        $user = User::factory()->create([
            'email' => 'andrey@email.com.br'
        ]);

        $user->assignRole('funcionario');

        $response = $this->delete(route('user.destroy', $user));
        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_should_delete_user()
    {
        $this->loginAsAdmin();

        $user = User::factory()->create([
            'email' => 'andrey@email.com.br'
        ]);

        $user->assignRole('funcionario');

        $response = $this->delete(route('user.destroy', $user));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
