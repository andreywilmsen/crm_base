<?php

namespace Modules\Record\Tests\Features\Record;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteRecordTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function a_guest_not_be_delete_record()
    {
        $recordToDestroy = RecordModel::factory()->create([
            'title' => 'Venda de título'
        ]);

        $response = $this->delete(route('record.destroy', $recordToDestroy->id));
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('records', ['id' => $recordToDestroy->id]);
    }

    #[Test]
    public function it_should_delete_record()
    {
        $this->loginAsFuncionario();

        $recordToDestroy = RecordModel::factory()->create([
            'title' => 'Venda de título'
        ]);

        $response = $this->delete(route('record.destroy', $recordToDestroy->id));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('records', ['id' => $recordToDestroy->id]);
    }

    #[Test]
    public function it_should_return_302_when_deleting_non_existent_record()
    {
        $this->loginAsFuncionario();

        $response = $this->delete(route('record.destroy', 99999));
        $response->assertStatus(302);
    }
}
