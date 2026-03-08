<?php

namespace Modules\Record\Tests\Features\RecordCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordCategoryModel;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetRecordCategoriesTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_list_all_record_categories()
    {
        $this->loginAsFuncionario();

        RecordCategoryModel::factory()->count(3)->create();

        $response = $this->get(route('record-category.index'));

        $response->assertStatus(200);
        $response->assertViewIs('record::categories.index');
        $response->assertViewHas('categories', function ($categories) {
            return count($categories) === 3;
        });
    }

    #[Test]
    public function a_guest_should_not_be_able_to_access_categories_list()
    {
        $response = $this->get(route('record-category.index'));

        $response->assertRedirect(route('login'));
    }
}
