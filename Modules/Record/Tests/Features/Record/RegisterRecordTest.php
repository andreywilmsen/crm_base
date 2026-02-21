<?php

namespace Modules\Record\Tests\Features\Record;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Record\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterRecordTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    private int $statusId;
    private int $categoryId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->statusId = DB::table('records_status')->insertGetId([
            'name' => 'Pendente',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->categoryId = DB::table('records_categories')->insertGetId([
            'name' => 'Consultoria',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    #[Test]
    public function a_guest_not_be_register_record()
    {
        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => 4,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('records', [
            'title'   => 'Venda de Consultoria',
            'value'   => 2500.00,
            'user_id' => 4
        ]);
    }

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
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
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
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
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
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
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
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['reference_date']);
    }

    #[Test]
    public function it_should_block_register_with_empty_statusId()
    {
        $user = $this->loginAsFuncionario();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => '',
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status_id']);
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
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => '',
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['user_id']);
    }

    #[Test]
    public function it_should_block_register_with_invalid_date()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => 'andrey wilmsen',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['reference_date']);
    }

    #[Test]
    public function it_should_block_register_with_invalid_value()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 'Andrey Wilmsen',
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['value']);
    }

    #[Test]
    public function it_should_block_register_with_invalid_userId()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => 4,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['user_id']);
    }

    #[Test]
    public function it_should_block_register_with_title_too_short()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Oi',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }

    #[Test]
    public function it_should_block_register_with_title_too_long()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => str_repeat('A', 256),
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }

    #[Test]
    public function it_should_block_register_with_description_too_long()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => str_repeat('D', 1001),
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['description']);
    }

    #[Test]
    public function it_should_block_register_with_negative_value()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => -10.50,
            'description'    => 'Tentativa de valor inválido.',
            'status_id'      => $this->statusId,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['value']);
    }

    #[Test]
    public function it_should_block_register_with_invalid_status()
    {
        $user = $this->loginAsAdmin();

        $data = [
            'title'          => 'Venda de Consultoria',
            'reference_date' => '2026-02-14',
            'value'          => 2500.00,
            'description'    => 'Serviço prestado para a empresa X.',
            'status_id'      => 9999,
            'category_id'    => $this->categoryId,
            'user_id'        => $user->id,
        ];

        $response = $this->post(route('record.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status_id']);
    }
}
