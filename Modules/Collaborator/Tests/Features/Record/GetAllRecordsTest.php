<?php

namespace Modules\Record\Tests\Features\Record;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetAllRecordsTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function a_guest_should_not_be_able_to_list_records()
    {
        $response = $this->get(route('record.index'));
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function it_should_get_all_records()
    {
        $this->loginAsFuncionario();

        $records = RecordModel::factory()->count(3)->create();

        $response = $this->get(route('record.index'));

        $response->assertStatus(200);

        $response->assertViewIs('record::Record.index');
        $response->assertViewHas('records', function ($viewRecords) {
            return count($viewRecords) === 3;
        });
        $response->assertSee($records->first()->title);
    }

    #[Test]
    public function it_should_return_empty_list_when_no_records_exist()
    {
        $this->loginAsFuncionario();

        $response = $this->get(route('record.index'));

        $response->assertStatus(200);
        $response->assertViewHas('records', []);
    }
}
