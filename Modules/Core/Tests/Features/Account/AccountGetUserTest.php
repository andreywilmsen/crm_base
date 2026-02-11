<?php

namespace Modules\Core\Tests\Features\Account;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountGetUserTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_redirect_unauthenticated_user_to_login()
    {
        $response = $this->get(route('account.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function it_should_get_user()
    {
        $user = $this->loginAsFuncionario();

        $response = $this->get(route('account.index'));
        $response->assertStatus(200);
        $response->assertViewIs('account::index');

        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->getEmail() === $user->email;
        });
    }

    #[Test]
    public function it_should_only_display_the_profile_of_the_authenticated_user()
    {
        $loggedUser = $this->loginAsFuncionario();
        $otherUser = \App\Models\User::factory()->create(['email' => 'outro@sistema.com']);

        $response = $this->get(route('account.index'));

        $response->assertStatus(200);

        $response->assertViewHas('user', function ($viewUser) use ($loggedUser, $otherUser) {
            return $viewUser->getEmail() === $loggedUser->email
                && $viewUser->getEmail() !== $otherUser->email;
        });

        $response->assertDontSee($otherUser->email);
    }
}
