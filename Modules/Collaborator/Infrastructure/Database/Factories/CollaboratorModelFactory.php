<?php

namespace Modules\Collaborator\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Collaborator\Infrastructure\Persistence\Eloquent\CollaboratorModel;

class CollaboratorModelFactory extends Factory
{
    protected $model = CollaboratorModel::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'phone'       => $this->faker->phoneNumber(),
            'email'       => $this->faker->unique()->safeEmail(),
        ];
    }
}
