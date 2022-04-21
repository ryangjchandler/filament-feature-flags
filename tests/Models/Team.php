<?php

namespace RyanChandler\FilamentFeatureFlags\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RyanChandler\FilamentFeatureFlags\Tests\Database\Factories\TeamFactory;
use RyanChandler\LaravelFeatureFlags\Models\Concerns\WithFeatures;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;

class Team extends Model implements HasFeatures
{
    use WithFeatures;
    use HasFactory;

    protected $table = 'filament_feature_flags_teams';

    public $guarded = [
        'id',
        'updated_at',
        'created_at',
    ];

    protected static function newFactory()
    {
        return TeamFactory::new();
    }
}
