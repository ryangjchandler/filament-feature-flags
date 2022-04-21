<?php

namespace RyanChandler\FilamentFeatureFlags\Tests\Filament\Resources;

use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use RyanChandler\FilamentFeatureFlags\Contracts\FlaggableResource;
use RyanChandler\FilamentFeatureFlags\Tests\Models\Team;

class TeamResource extends Resource implements FlaggableResource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $label = 'Posts';

    public static function getFlaggableRecordDisplayColumn(): string
    {
        return 'name';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            //
        ];
    }
}