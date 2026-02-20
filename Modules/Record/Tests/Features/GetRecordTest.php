<?php

namespace Modules\Record\Tests\Features;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetRecordTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function a_guest_not_be_a_get_record()
    {
        $recordToGet = RecordModel::factory()->create([
            'title' => 'Venda de título'
        ]);

        $response = $this->get(route('record.show', $recordToGet->id));
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function it_should_get_record()
    {
        $this->loginAsFuncionario();

        $recordToGet = RecordModel::factory()->create([
            'title' => 'Venda de título'
        ]);

        $response = $this->get(route('record.show', $recordToGet->id));
        $response->assertStatus(200);
        $response->assertSee($recordToGet->id);
        $response->assertViewHas('record');
    }

    #[Test]
    public function it_should_redirect_to_index_when_record_does_not_exist()
    {
        $this->loginAsFuncionario();

        $response = $this->get(route('record.show', 9999));
        $response->assertStatus(302);
        $response->assertRedirect(route('record.index'));
        $response->assertSessionHasErrors(['error']);
    }
}
