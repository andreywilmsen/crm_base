<?php

namespace Modules\Record\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Modules\Record\Domain\Entities\RecordStatus;

class RecordStatusEntityTest extends TestCase
{
    #[Test]
    public function it_should_instantiate_a_record_status()
    {
        $name = 'Completed';
        $id = 1;
        $now = new \DateTime();

        $status = new RecordStatus(
            id: $id,
            name: $name,
            createdAt: $now,
            updatedAt: $now
        );

        $this->assertEquals($id, $status->getId());
        $this->assertEquals($name, $status->getName());
        $this->assertEquals($now, $status->getCreatedAt());
        $this->assertEquals($now, $status->getUpdatedAt());
    }

    #[Test]
    public function it_should_block_with_empty_name()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O nome do status é obrigatório.');

        new RecordStatus(
            id: 1,
            name: ''
        );
    }

    #[Test]
    public function it_should_block_with_name_containing_only_spaces()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O nome do status é obrigatório.');

        new RecordStatus(
            id: 1,
            name: '   '
        );
    }

    #[Test]
    public function it_should_allow_null_id_for_new_categories()
    {
        $status = new RecordStatus(
            id: null,
            name: 'Novo Status'
        );

        $this->assertNull($status->getId());
        $this->assertEquals('Novo Status', $status->getName());
    }
}
