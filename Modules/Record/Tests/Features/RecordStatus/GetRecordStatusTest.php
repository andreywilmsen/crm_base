<?php

namespace Modules\Record\Tests\Features\RecordStatus;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordStatusModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetRecordStatusTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_list_all_record_status()
    {
        $this->loginAsFuncionario();

        RecordStatusModel::factory()->count(3)->create();

        $response = $this->get(route('record-status.index'));

        $response->assertStatus(200);
        $response->assertViewIs('record::status.index');
        $response->assertViewHas('status', function ($status) {
            return count($status) === 3;
        });
    }

    #[Test]
    public function a_guest_should_not_be_able_to_access_status_list()
    {
        $response = $this->get(route('record-status.index'));

        $response->assertRedirect(route('login'));
    }
}
