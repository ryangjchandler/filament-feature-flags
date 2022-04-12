<?php

namespace RyanChandler\FilamentFeatureFlags\Resources;

use Closure;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use RyanChandler\FilamentFeatureFlags\Contracts\FlaggableResource;
use RyanChandler\FilamentFeatureFlags\Resources\FeatureFlagResource\Pages;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;
use RyanChandler\LaravelFeatureFlags\Models\FeatureFlag;

class FeatureFlagResource extends Resource
{
    protected static ?string $model = FeatureFlag::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    protected static ?string $label = 'Features';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Card::make([
                        TextInput::make('name')
                            ->required(),
                        Textarea::make('description')
                            ->nullable()
                            ->maxLength(255),
                        Toggle::make('enabled')
                            ->default(false),
                    ]),
                    Section::make('Model')
                        ->schema([
                            Select::make('flaggable_type')
                                ->label('Resource Type')
                                ->options(function () {
                                    return collect(Filament::getResources())
                                        ->filter(function (string $resource) {
                                            return in_array(HasFeatures::class, class_implements($resource::getModel())) &&
                                                in_array(FlaggableResource::class, class_implements($resource));
                                        })
                                        ->mapWithKeys(function (string $resource) {
                                            $model = new ($resource::getModel());

                                            return [
                                                $resource => class_basename($model),
                                            ];
                                        });
                                })
                                ->nullable()
                                ->afterStateHydrated(function ($component, $state) {
                                    $resources = collect(Filament::getResources());
                                    $resource = $resources->first(fn (string $resource) => $resource::getModel() === $state);

                                    $component->state($resource);
                                })
                                ->afterStateUpdated(function ($set, $state) {
                                    if (! $state) {
                                        $set('flaggable_id', null);
                                    }
                                })
                                ->dehydrateStateUsing(function (?string $state) {
                                    if (! $state) {
                                        return $state;
                                    }

                                    $model = $state::getModel();

                                    return (new $model())->getMorphClass();
                                })
                                ->reactive(),
                            Select::make('flaggable_id')
                                ->label('Resource')
                                ->visible(fn ($get) => ! ! $get('flaggable_type'))
                                ->required(fn ($get) => $get('flaggable_type'))
                                ->searchable()
                                ->getSearchResultsUsing(function (Closure $get, ?string $query) {
                                    $resource = $get('flaggable_type');
                                    $displayColumn = $resource::getFlaggableRecordDisplayColumn();
                                    $model = new ($resource::getModel());

                                    return $model::query()
                                        ->when($query, fn (Builder $q) => $q->where($displayColumn, 'LIKE', "%{$query}%"))
                                        ->pluck($displayColumn, $model->getKeyName());
                                })
                                ->getOptionLabelUsing(function (Closure $get, $state) {
                                    if (! $state) {
                                        return null;
                                    }

                                    $resource = $get('flaggable_type');
                                    $displayColumn = $resource::getFlaggableRecordDisplayColumn();
                                    $model = new ($resource::getModel());

                                    return $model::find($state)?->{$displayColumn};
                                }),
                        ]),
                ])
                    ->columnSpan(4),
                Card::make([
                    Placeholder::make('created_at')
                        ->label('Created at')
                        ->content(fn (?FeatureFlag $record) => $record ? $record->created_at->diffForHumans() : new HtmlString('&mdash;')),
                    Placeholder::make('updated_at')
                        ->label('Updated at')
                        ->content(fn (?FeatureFlag $record) => $record ? $record->updated_at->diffForHumans() : new HtmlString('&mdash;')),
                ])
                    ->columnSpan(2),
            ])
            ->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                BooleanColumn::make('enabled')
                    ->action(fn (FeatureFlag $record) => $record->update(['enabled' => ! $record->enabled]))
                    ->sortable(),
                TextColumn::make('flaggable_type')
                    ->label('Resource Type')
                    ->formatStateUsing(function (?string $state, FeatureFlag $record) {
                        if (! $state) {
                            return new HtmlString('&mdash;');
                        }

                        return class_basename($record->flaggable::class);
                    }),
                TextColumn::make('flaggable_id')
                    ->label('Resource')
                    ->formatStateUsing(function (int|string|null $state, FeatureFlag $record) {
                        if (! $state || ! $record->flaggable_type) {
                            return new HtmlString('&mdash;');
                        }

                        $resource = collect(Filament::getResources())
                            ->filter(function (string $resource) {
                                return in_array(HasFeatures::class, class_implements($resource::getModel())) &&
                                    in_array(FlaggableResource::class, class_implements($resource));
                            })
                            ->first(function (string $resource) use ($record) {
                                $model = $resource::getModel();

                                return (new $model())->getMorphClass() === $record->flaggable::class;
                            });

                        $displayColumn = $resource::getFlaggableRecordDisplayColumn();

                        return $record->flaggable?->{$displayColumn} ?? new HtmlString('&mdash;');
                    }),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'enabled' => 'Enabled',
                        'disabled' => 'Disabled',
                    ])
                    ->default('all')
                    ->query(function (Builder $query, array $data) {
                        $query
                            ->when($data['value'] === 'enabled', fn ($query) => $query->where('enabled', true))
                            ->when($data['value'] === 'disabled', fn ($query) => $query->where('enabled', false));
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatureFlags::route('/'),
            'create' => Pages\CreateFeatureFlag::route('/create'),
            'edit' => Pages\EditFeatureFlag::route('/{record}/edit'),
        ];
    }
}
