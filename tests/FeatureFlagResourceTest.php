<?php

use Livewire\Livewire;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages\CreateFeatureFlag;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages\ListFeatureFlags;
use RyanChandler\FilamentFeatureFlags\Tests\Models\Post;
use RyanChandler\FilamentFeatureFlags\Tests\Models\Team;
use RyanChandler\LaravelFeatureFlags\Models\FeatureFlag;

it('can be mounted', function () {
    Livewire::test(CreateFeatureFlag::class)
        ->assertSuccessful();
});

it('works with string key models', function () {
    Livewire::test(CreateFeatureFlag::class)
        ->set('data.name', 'test')
        ->set('data.flaggable_type', Team::class)
        ->set('data.flaggable_id', 'a1f43340-9fc9-43d5-8519-139c4a4559a5')
        ->call('create')
        ->assertHasNoErrors();
});

it('works with integer key models', function () {
    Livewire::test(CreateFeatureFlag::class)
        ->set('data.name', 'test')
        ->set('data.flaggable_type', Team::class)
        ->set('data.flaggable_id', 123)
        ->call('create')
        ->assertHasNoErrors();
});

it('shows features with string type keys', function () {
    $post = Post::factory()->create();

    FeatureFlag::factory([
        'name' => 'Testflag',
        'enabled' => true,
        'flaggable_type' => Post::class,
        'flaggable_id' => $post->id,
    ])->create();

    Livewire::test(ListFeatureFlags::class)
        ->assertSuccessful();
});

it('shows features with integer type keys', function () {
    $team = Team::factory()->create();

    FeatureFlag::factory([
        'name' => 'Testflag',
        'enabled' => true,
        'flaggable_type' => Team::class,
        'flaggable_id' => $team->id,
    ])->create();

    Livewire::test(ListFeatureFlags::class)
        ->assertSuccessful();
});
