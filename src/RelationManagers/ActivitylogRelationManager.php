<?php

namespace Bestora\FilamentActivityLog\RelationManagers;

use Bestora\FilamentActivityLog\ActivitylogPlugin;
use Bestora\FilamentActivityLog\Resources\ActivitylogResource\ActivitylogResource;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ActivitylogRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $recordTitleAttribute = 'description';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return static::$title ?? (string) str(ActivitylogPlugin::get()->getPluralLabel())
            ->kebab()
            ->replace('-', ' ')
            ->headline();
    }

    public function form(Schema $schema): Schema
    {
        return ActivitylogResource::form($schema);
    }

    public function table(Table $table): Table
    {
        return ActivitylogResource::table(
            $table
                ->heading(ActivitylogPlugin::get()->getPluralLabel())
                ->recordActions([
                    ViewAction::make(),
                ])
        );
    }
}
