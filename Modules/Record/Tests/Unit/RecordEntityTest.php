<?php

namespace Modules\Record\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Modules\Record\Domain\Entities\Record;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RecordEntityTest extends TestCase
{
    use RefreshDatabase;

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
    public function it_should_instance_record()
    {

        $record = new Record(
            title: 'Orçamento de energia',
            referenceDate: '2025-12-25',
            value: 406.3,
            description: 'Fatura de Janeiro',
            statusId: $this->statusId,
            categoryId: $this->categoryId,
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
            statusId: $this->statusId,
            categoryId: $this->categoryId,
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
            statusId: $this->statusId,
            categoryId: $this->categoryId,
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
            statusId: $this->statusId,
            categoryId: $this->categoryId,
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
            statusId: $this->statusId,
            categoryId: $this->categoryId,
            userId: 4,
        );
    }

    #[Test]
    public function it_should_block_with_empty_statusId()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Campo status é obrigatório.');

        new Record(
            title: 'Orçamento de energia',
            referenceDate: '2025-12-25',
            value: 406.3,
            description: 'Fatura de Janeiro',
            statusId: 0,
            categoryId: $this->categoryId,
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
            statusId: $this->statusId,
            categoryId: $this->categoryId,
            userId: 0,
        );
    }
}
