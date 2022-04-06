<?php

namespace RyanChandler\FilamentFeatureFlags;

use Filament\PluginServiceProvider;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;

class FilamentFeatureFlagsServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-feature-flags';

    protected array $resources = [
        FeatureFlagResource::class,
    ];
}
