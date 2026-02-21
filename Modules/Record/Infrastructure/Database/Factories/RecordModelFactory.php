<?php

namespace Modules\Record\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordStatusModel;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordCategoryModel;
use App\Models\User;

class RecordModelFactory extends Factory
{
    protected $model = RecordModel::class;

    public function definition(): array
    {
        return [
            'title'          => $this->faker->sentence(3),
            'reference_date' => $this->faker->date(),
            'value'          => $this->faker->randomFloat(2, 10, 5000),
            'description'    => $this->faker->paragraph(),
            'status_id'      => RecordStatusModel::factory(),
            'category_id'    => RecordCategoryModel::factory(),
            'user_id'        => User::factory(),
        ];
    }
}
