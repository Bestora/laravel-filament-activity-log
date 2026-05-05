<?php

namespace Bestora\FilamentActivityLog\Resources\ActivitylogResource\Pages;

use Bestora\FilamentActivityLog\Resources\ActivitylogResource\ActivitylogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewActivitylog extends ViewRecord
{
    public static function getResource(): string
    {
        return ActivitylogResource::class;
    }
}
