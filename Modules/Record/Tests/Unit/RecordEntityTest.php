<?php

namespace Modules\Record\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Record\Domain\Entities\Record;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RecordEntityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_instance_record()
    {
        $data = [
            'title' => 'Orçamento de energia',
            'data' => '2025-12-25',
            'value' => 406.3,
            'description' => 'Fatura de Janeiro',
            'status' => 'pending',
        ];

        $record = new Record($data);

        $this->assertInstanceOf(Record::class, $record);

        $this->assertEquals('Orçamento de energia', $record->title);
        $this->assertEquals(406.3, $record->value);
    }
}
