<?php

namespace RyanChandler\FilamentFeatureFlags\Contracts;

interface FlaggableResource
{
    public static function getFlaggableRecordDisplayColumn(): string;
}
