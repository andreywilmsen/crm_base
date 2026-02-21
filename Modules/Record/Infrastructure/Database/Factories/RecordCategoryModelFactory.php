<?php

namespace Modules\Record\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordCategoryModel;

class RecordCategoryModelFactory extends Factory
{
    protected $model = RecordCategoryModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }
}