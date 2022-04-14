<?php

namespace RyanChandler\FilamentFeatureFlags\Tests;

use Filament\Facades\Filament;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Support\Facades\Artisan;
use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\FilamentFeatureFlags\FilamentFeatureFlagsServiceProvider;
use RyanChandler\FilamentFeatureFlags\Tests\Filament\Resources\PostResource;
use RyanChandler\FilamentFeatureFlags\Tests\Filament\Resources\TeamResource;
use RyanChandler\LaravelFeatureFlags\LaravelFeatureFlagsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'RyanChandler\\LaravelFeatureFlags\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            TablesServiceProvider::class,
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            FilamentFeatureFlagsServiceProvider::class,
            LaravelFeatureFlagsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.key', 'base64:j4TkRHy8hbJCJ255PmYRqn5pvxrhf3QKvJcrBj0M/gY=');
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/database/migrations/create_test_tables.php.stub';
        $migration->up();

        Artisan::call('vendor:publish', [
            '--tag' => 'feature-flags-migrations',
        ]);

        Artisan::call('migrate');

        Filament::registerResources([
            PostResource::class,
            TeamResource::class,
        ]);
    }
}
