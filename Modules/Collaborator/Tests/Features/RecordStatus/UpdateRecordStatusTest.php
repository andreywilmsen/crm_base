<?php

namespace Modules\Record\Tests\Features\RecordStatus;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordStatusModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateRecordStatusTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_update_an_existing_status()
    {
        $this->loginAsFuncionario();

        $status = RecordStatusModel::create(['name' => 'Old Name']);

        $newData = [
            'name' => 'Updated Name'
        ];

        $response = $this->put(route('record-status.update', $status->id), $newData);

        $response->assertRedirect(route('record-status.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('records_status', [
            'id' => $status->id,
            'name' => 'Updated Name'
        ]);

        $this->assertDatabaseMissing('records_status', [
            'name' => 'Old Name'
        ]);
    }

    #[Test]
    public function it_should_block_update_with_empty_name()
    {
        $this->loginAsFuncionario();

        $status = RecordStatusModel::create(['name' => 'Should Not Change']);

        $response = $this->put(route('record-status.update', $status->id), ['name' => '']);

        $response->assertSessionHasErrors('name');

        $this->assertDatabaseHas('records_status', [
            'id' => $status->id,
            'name' => 'Should Not Change'
        ]);
    }

    #[Test]
    public function it_should_return_404_when_updating_non_existent_status()
    {
        $this->loginAsFuncionario();

        $response = $this->put(route('record-status.update', 9999), ['name' => 'New Name']);

        $response->assertRedirect(route('record-status.index'));
        $response->assertSessionHasErrors('error');
    }
}
