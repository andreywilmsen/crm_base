<?php

namespace Modules\Record\Tests\Features\RecordCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordCategoryModel;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteRecordCategoryTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_delete_a_record_category()
    {
        $this->loginAsFuncionario();
        $category = RecordCategoryModel::factory()->create();

        $response = $this->delete(route('record-category.destroy', $category->id));

        $response->assertRedirect(route('record-category.index'));
        $this->assertDatabaseMissing('records_categories', [
            'id' => $category->id
        ]);
    }

    #[Test]
    public function a_guest_should_not_be_able_to_delete_a_category()
    {
        $category = RecordCategoryModel::factory()->create();

        $response = $this->delete(route('record-category.destroy', $category->id));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('records_categories', [
            'id' => $category->id
        ]);
    }

    #[Test]
    public function it_should_block_deletion_if_category_has_records()
    {
        $this->loginAsFuncionario();

        $category = RecordCategoryModel::factory()->create();
        RecordModel::factory()->create(['category_id' => $category->id]);

        $response = $this->delete(route('record-category.destroy', $category->id));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('records_categories', [
            'id' => $category->id
        ]);
    }
}
