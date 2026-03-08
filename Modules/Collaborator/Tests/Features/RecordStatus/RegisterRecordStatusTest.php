<?php

namespace Modules\Record\Tests\Features\RecordStatus;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterRecordStatusTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_register_a_new_status()
    {
        $this->loginAsFuncionario();

        $data = [
            'name' => 'Completed'
        ];

        $response = $this->post(route('record-status.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('records_status', [
            'name' => 'Completed'
        ]);
    }

    #[Test]
    public function it_should_block_register_with_empty_name()
    {
        $this->loginAsFuncionario();

        $response = $this->post(route('record-status.store'), ['name' => '']);

        $response->assertSessionHasErrors('name');
    }
}
