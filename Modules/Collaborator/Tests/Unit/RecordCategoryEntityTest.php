<?php

namespace Modules\Record\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Modules\Record\Domain\Entities\RecordCategory;

class RecordCategoryEntityTest extends TestCase
{
    #[Test]
    public function it_should_instantiate_a_record_category()
    {
        $name = 'Vendas';
        $id = 1;
        $now = new \DateTime();

        $category = new RecordCategory(
            id: $id,
            name: $name,
            createdAt: $now,
            updatedAt: $now
        );

        $this->assertEquals($id, $category->getId());
        $this->assertEquals($name, $category->getName());
        $this->assertEquals($now, $category->getCreatedAt());
        $this->assertEquals($now, $category->getUpdatedAt());
    }

    #[Test]
    public function it_should_block_with_empty_name()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O nome da categoria é obrigatório.');

        new RecordCategory(
            id: 1,
            name: ''
        );
    }

    #[Test]
    public function it_should_block_with_name_containing_only_spaces()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O nome da categoria é obrigatório.');

        new RecordCategory(
            id: 1,
            name: '   '
        );
    }

    #[Test]
    public function it_should_allow_null_id_for_new_categories()
    {
        $category = new RecordCategory(
            id: null,
            name: 'Nova Categoria'
        );

        $this->assertNull($category->getId());
        $this->assertEquals('Nova Categoria', $category->getName());
    }
}
