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

        $record = new Record(
            title: 'Orçamento de energia',
            referenceDate: '2025-12-25',
            value: 406.3,
            description: 'Fatura de Janeiro',
            status: 'pending',
            userId: 1,
        );

        $this->assertInstanceOf(Record::class, $record);
        $this->assertEquals('Orçamento de energia', $record->getTitle());
        $this->assertEquals(406.3, $record->getValue());
    }

    #[Test]
    public function it_should_block_with_empty_title()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo título é obrigatório.');

        new Record(
            title: '',
            referenceDate: '2025-12-25',
            value: 406.3,
            description: 'Fatura de Janeiro',
            status: 'pending',
            userId: 1,
        );
    }

    #[Test]
    public function it_should_block_with_empty_referenceDate()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo data é obrigatório.');

        new Record(
            title: 'Orçamento de energia',
            referenceDate: '',
            value: 406.3,
            description: 'Fatura de Janeiro',
            status: 'pending',
            userId: 1,
        );
    }

    #[Test]
    public function it_should_block_with_empty_description()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo descrição é obrigatório.');

        new Record(
            title: 'Orçamento de energia',
            referenceDate: '2025-12-25',
            value: 406.3,
            description: '',
            status: 'pending',
            userId: 1,
        );
    }

    #[Test]
    public function it_should_block_negative_value()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Valores negativos não são permitidos.');

        new Record(
            title: 'Orçamento de energia',
            referenceDate: '2025-12-25',
            value: -406.3,
            description: 'Fatura de Janeiro',
            status: 'pending',
            userId: 4,
        );
    }

    #[Test]
    public function it_should_block_with_empty_status()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo status é obrigatório.');

        new Record(
            title: 'Orçamento de energia',
            referenceDate: '2025-12-25',
            value: 406.3,
            description: 'Fatura de Janeiro',
            status: '',
            userId: 1,
        );
    }

    #[Test]
    public function it_should_block_with_empty_userId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo responsável é obrigatório.');

        new Record(
            title: 'Orçamento de energia',
            referenceDate: '2025-12-25',
            value: 406.3,
            description: 'Fatura de Janeiro',
            status: 'pending',
            userId: 0,
        );
    }
}
