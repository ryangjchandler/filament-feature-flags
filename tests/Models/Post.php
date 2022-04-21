<?php

namespace RyanChandler\FilamentFeatureFlags\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use RyanChandler\FilamentFeatureFlags\Tests\Database\Factories\PostFactory;
use RyanChandler\LaravelFeatureFlags\Models\Concerns\WithFeatures;
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;

class Post extends Model implements HasFeatures
{
    use HasFactory;
    use WithFeatures;

    protected $table = 'filament_feature_flags_posts';

    public $guarded = [
        'id',
        'updated_at',
        'created_at',
    ];

    protected static function boot()
    {
        self::creating(function ($model) {
            $model->id = Uuid::uuid4();
        });

        parent::boot();
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected static function newFactory()
    {
        return PostFactory::new();
    }
}
