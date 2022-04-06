<?php

namespace RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource;

class ListFeatureFlags extends ListRecords
{
    protected static string $resource = FeatureFlagResource::class;

    protected function getCreateAction(): Action
    {
        return parent::getCreateAction()
            ->label('Add Feature');
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No feature flags found.';
    }
}
