<?php

namespace Modules\Core\Tests\Features\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserFindAllTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;


    #[Test]
    public function a_guest_not_be_able_see_all_users()
    {
        $response = $this->get(route('user.index'));
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function a_funcionario_not_be_able_to_see_all_users()
    {
        $this->loginAsFuncionario();

        $response = $this->get(route('user.index'));
        $response->assertStatus(403);
    }

    #[Test]
    public function it_should_list_all_users()
    {
        $this->loginAsAdmin();

        $userA = User::factory()->create(['email' => 'andrey@email.com.br']);
        $userA->assignRole('funcionario');
        $userB = User::factory()->create(['email' => 'joao@email.com.br']);
        $userB->assignRole('funcionario');

        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
        $response->assertSee('andrey@email.com.br');
        $response->assertSee('joao@email.com.br');
    }
}
