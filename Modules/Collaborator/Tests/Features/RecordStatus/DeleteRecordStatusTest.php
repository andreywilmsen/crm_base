<?php

namespace Modules\Record\Tests\Features\RecordStatus;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordStatusModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteRecordStatusTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_delete_a_record_status()
    {
        $this->loginAsFuncionario();
        $status = RecordStatusModel::factory()->create();

        $response = $this->delete(route('record-status.destroy', $status->id));

        $response->assertRedirect(route('record-status.index'));
        $this->assertDatabaseMissing('records_status', [
            'id' => $status->id
        ]);
    }

    #[Test]
    public function a_guest_should_not_be_able_to_delete_a_status()
    {
        $status = RecordStatusModel::factory()->create();

        $response = $this->delete(route('record-status.destroy', $status->id));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('records_status', [
            'id' => $status->id
        ]);
    }

    #[Test]
    public function it_should_block_deletion_if_status_has_records()
    {
        $this->loginAsFuncionario();

        $status = RecordStatusModel::factory()->create();
        RecordModel::factory()->create(['status_id' => $status->id]);

        $response = $this->delete(route('record-status.destroy', $status->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('records_status', [
            'id' => $status->id
        ]);
    }
}
