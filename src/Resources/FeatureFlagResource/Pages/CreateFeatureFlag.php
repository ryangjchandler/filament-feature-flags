<?php

namespace RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages;

use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeatureFlag extends CreateRecord
{
    protected static string $resource = FeatureFlagResource::class;
}
