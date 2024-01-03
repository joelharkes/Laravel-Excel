<?php

namespace Maatwebsite\Excel\Tests\Data\Stubs\Database\Factories;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Tests\Data\Stubs\Database\User;

class UserFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => Str::random(10),
        ];
    }
}
