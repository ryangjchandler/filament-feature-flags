<?php

namespace RyanChandler\FilamentFeatureFlags\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RyanChandler\FilamentFeatureFlags\Tests\Models\Team;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
