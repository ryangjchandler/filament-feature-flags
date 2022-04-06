<?php

namespace RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;

class CreateFeatureFlag extends CreateRecord
{
    protected static string $resource = FeatureFlagResource::class;
}
