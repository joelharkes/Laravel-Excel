<?php

namespace Maatwebsite\Excel\Tests\Data\Stubs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Maatwebsite\Excel\Tests\Data\Stubs\Database\Group;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
