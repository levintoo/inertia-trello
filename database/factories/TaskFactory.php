<?php

namespace Database\Factories;

use App\Models\Column;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'position' => fake()->randomNumber(),
            'due_date' => Carbon::now(),
            'completed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'column_id' => Column::factory(),
            'user_id' => User::factory(),
        ];
    }
}
