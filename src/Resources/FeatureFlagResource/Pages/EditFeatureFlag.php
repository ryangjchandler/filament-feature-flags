<?php

namespace RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages;

use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;
use Filament\Resources\Pages\EditRecord;

class EditFeatureFlag extends EditRecord
{
    protected static string $resource = FeatureFlagResource::class;
}
