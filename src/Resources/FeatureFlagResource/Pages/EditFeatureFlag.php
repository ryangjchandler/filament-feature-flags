<?php

namespace RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages;

use Filament\Resources\Pages\EditRecord;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;

class EditFeatureFlag extends EditRecord
{
    protected static string $resource = FeatureFlagResource::class;
}
