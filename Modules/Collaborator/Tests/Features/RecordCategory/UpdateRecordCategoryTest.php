<?php

namespace Modules\Record\Tests\Features\RecordCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordCategoryModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateRecordCategoryTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_update_an_existing_category()
    {
        $this->loginAsFuncionario();

        $category = RecordCategoryModel::create(['name' => 'Categoria Antiga']);

        $newData = [
            'name' => 'Categoria Atualizada'
        ];

        $response = $this->put(route('record-category.update', $category->id), $newData);

        $response->assertRedirect(route('record-category.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('records_categories', [
            'id' => $category->id,
            'name' => 'Categoria Atualizada'
        ]);

        $this->assertDatabaseMissing('records_categories', [
            'name' => 'Categoria Antiga'
        ]);
    }

    #[Test]
    public function it_should_block_update_with_empty_name()
    {
        $this->loginAsFuncionario();

        $category = RecordCategoryModel::create(['name' => 'Nome Valido']);

        $response = $this->put(route('record-category.update', $category->id), ['name' => '']);

        $response->assertSessionHasErrors('name');

        $this->assertDatabaseHas('records_categories', [
            'id' => $category->id,
            'name' => 'Nome Valido'
        ]);
    }

    #[Test]
    public function it_should_return_error_when_updating_non_existent_category()
    {
        $this->loginAsFuncionario();

        $response = $this->put(route('record-category.update', 9999), ['name' => 'Teste']);

        $response->assertRedirect(route('record-category.index'));
        $response->assertSessionHasErrors('error');
    }
}
