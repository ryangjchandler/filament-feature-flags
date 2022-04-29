<?php

namespace RyanChandler\FilamentFeatureFlags;

use Filament\PluginServiceProvider;
use Filament\Tables\Columns\Column;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;
use RyanChandler\LaravelFeatureFlags\Facades\Features;
use Filament\Forms\Components\Component;

class FilamentFeatureFlagsServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-feature-flags';

    protected array $resources = [
        FeatureFlagResource::class,
    ];

    protected function registerMacros(): void
    {
        Component::macro('featureEnabled', function (string $featureFlag): static {
            $this->isVisible = Features::enabled($featureFlag);

            return $this;
        });

        Component::macro('featureDisabled', function (string $featureFlag): static {
            $this->isVisible = Features::disabled($featureFlag);

            return $this;
        });

        Column::macro('featureEnabled', function (string $featureFlag): static {
            $this->isVisible = Features::enabled($featureFlag);

            return $this;
        });

        Column::macro('featureDisabled', function (string $featureFlag): static {
            $this->isVisible = Features::disabled($featureFlag);

            return $this;
        });
    }
}
