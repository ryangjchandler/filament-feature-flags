<?php

namespace RyanChandler\FilamentFeatureFlags;

use Closure;
use Filament\PluginServiceProvider;
use Filament\Tables\Columns\Column;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;
use RyanChandler\LaravelFeatureFlags\Facades\Features;
use Filament\Forms\Components\Component;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;

class FilamentFeatureFlagsServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-feature-flags';

    protected array $resources = [
        FeatureFlagResource::class,
    ];

    protected function registerMacros(): void
    {
        Component::macro('featureEnabled', function (string $name, HasFeatures|Closure $for = null): static {
            $this->visible(function () use ($name, $for) {
                return Features::enabled($name, for: $this->evaluate($for));
            });

            return $this;
        });

        Component::macro('featureDisabled', function (string $featureFlag, HasFeatures|Closure $for = null): static {
            $this->visible(function () use ($name, $for) {
                return Features::disabled($name, for: $this->evaluate($for));
            });

            return $this;
        });

        Column::macro('featureEnabled', function (string $featureFlag, HasFeatures|Closure $for = null): static {
            $this->visible(function () use ($name, $for) {
                return Features::enabled($name, for: $this->evaluate($for));
            });

            return $this;
        });

        Column::macro('featureDisabled', function (string $featureFlag, HasFeatures|Closure $for = null): static {
            $this->visible(function () use ($name, $for) {
                return Features::disabled($name, for: $this->evaluate($for));
            });

            return $this;
        });
    }
}
