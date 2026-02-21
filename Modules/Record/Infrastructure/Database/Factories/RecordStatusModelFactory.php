<?php

namespace Modules\Record\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordStatusModel;

class RecordStatusModelFactory extends Factory
{
    protected $model = RecordStatusModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }
}
