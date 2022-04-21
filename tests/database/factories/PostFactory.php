<?php

namespace RyanChandler\FilamentFeatureFlags\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RyanChandler\FilamentFeatureFlags\Tests\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
