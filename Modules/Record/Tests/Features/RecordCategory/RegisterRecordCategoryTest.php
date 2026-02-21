<?php

namespace Modules\Record\Tests\Features\RecordCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Tests\Traits\InteractsWithRoles;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterRecordCategoryTest extends TestCase
{
    use RefreshDatabase, InteractsWithRoles;

    #[Test]
    public function it_should_register_a_new_category()
    {
        $this->loginAsFuncionario();

        $data = [
            'name' => 'Consultoria Técnica'
        ];

        $response = $this->post(route('record-category.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('records_categories', [
            'name' => 'Consultoria Técnica'
        ]);
    }

    #[Test]
    public function it_should_block_register_with_empty_name()
    {
        $this->loginAsFuncionario();

        $response = $this->post(route('record-category.store'), ['name' => '']);

        $response->assertSessionHasErrors('name');
    }
}
