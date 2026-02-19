<?php

namespace Modules\Record\Tests\Features;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Record\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterRecordTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_register_record()
    {
        $this->withoutExceptionHandling();

        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status'         => 'completed',
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store', $data));
        $response->assertStatus(302);
        $this->assertDatabaseHas('records', [
            'title'   => 'Venda de Consultoria',
            'value'   => 2500.00,
            'user_id' => $user->id
        ]);
    }

    #[Test]
    public function it_should_block_register_with_empty_title()
    {
        $user = $this->loginAsFuncionario();

        $data = [
            'title'          => '',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status'         => 'completed',
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }

    #[Test]
    public function it_should_block_register_with_empty_description()
    {
        $user = $this->loginAsFuncionario();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => '',
            'status'         => 'completed',
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['description']);
    }

    #[Test]
    public function it_should_block_register_with_empty_reference_data()
    {
        $user = $this->loginAsFuncionario();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status'         => 'completed',
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['reference_date']);
    }

    #[Test]
    public function it_should_block_register_with_empty_status()
    {
        $user = $this->loginAsFuncionario();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status'         => '',
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status']);
    }

    #[Test]
    public function it_should_block_register_with_empty_userId()
    {
        $this->loginAsFuncionario();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status'         => '',
            'user_id'        => '',
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['user_id']);
    }
}
