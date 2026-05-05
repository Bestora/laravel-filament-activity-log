<?php

namespace Bestora\FilamentActivityLog\Resources\ActivitylogResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Bestora\FilamentActivityLog\Resources\ActivitylogResource\ActivitylogResource;

class ListActivitylog extends ListRecords
{
    protected static string $resource = ActivitylogResource::class;
}
