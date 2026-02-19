<?php

namespace Modules\Record\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;
use App\Models\User;

class RecordModelFactory extends Factory
{
    // Define qual modelo esta factory cria
    protected $model = RecordModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'          => $this->faker->sentence(3),
            'reference_date' => $this->faker->date(),
            'value'          => $this->faker->randomFloat(2, 10, 1000),
            'description'    => $this->faker->paragraph(),
            'status'         => $this->faker->randomElement(['pending', 'completed']),
            'user_id'        => User::factory(),
        ];
    }
}
