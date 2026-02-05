<?php

namespace Modules\Core\Tests\Unit\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Domain\User\Entities\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserEntityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_create_user()
    {
        $id = 1;
        $name = 'José Carlos';
        $email = 'jose@email.com';
        $emailVerifiedAt = new \DateTime();
        $password = 'hash-password';
        $rememberToken = null;
        $role = 'admin';

        $user = new User(
            id: $id,
            name: $name,
            email: $email,
            emailVerifiedAt: $emailVerifiedAt,
            password: $password,
            rememberToken: $rememberToken,
            role: $role
        );

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($role, $user->getRole());
    }

    #[Test]
    public function it_should_block_create_with_empty_name()
    {

        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage('O nome é obrigatório.');

        new User(
            id: 1,
            name: '',
            email: 'jose@email.com',
            emailVerifiedAt: new \DateTime(),
            password: 'hash-password',
            rememberToken: null,
            role: 'admin'
        );
    }

    #[Test]
    public function it_should_block_create_with_short_name()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('O nome deverá ter mais que 3 caracteres.');

        new User(
            id: 1,
            name: 'Al',
            email: 'alexandre@admin.com',
            emailVerifiedAt: new \DateTime(),
            password: 'hash-password',
            rememberToken: null,
            role: 'admin'
        );
    }

    #[Test]
    public function it_should_block_create_with_invalid_email()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('E-mail inválido.');

        new User(
            id: 1,
            name: 'José Carlos Alexandre',
            email: 'josecarlosalexandre',
            emailVerifiedAt: new \DateTime(),
            password: 'hash-password',
            rememberToken: null,
            role: 'admin'
        );
    }

    #[Test]
    public function it_should_block_create_with_empty_password(){
        $this->expectException(\InvalidArgumentException::class);
        
        $this->expectExceptionMessage('A senha é obrigatória.');

         new User(
            id: 1,
            name: 'José Carlos Alexandre',
            email: 'jose@admin.com',
            emailVerifiedAt: new \DateTime(),
            password: '',
            rememberToken: null,
            role: 'admin'
        );
    }
}
