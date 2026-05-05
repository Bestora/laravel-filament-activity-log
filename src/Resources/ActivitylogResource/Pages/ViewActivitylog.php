<?php

namespace Bestora\FilamentActivityLog\Resources\ActivitylogResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Bestora\FilamentActivityLog\Resources\ActivitylogResource\ActivitylogResource;

class ViewActivitylog extends ViewRecord
{
    public static function getResource(): string
    {
        return ActivitylogResource::class;
    }
}
