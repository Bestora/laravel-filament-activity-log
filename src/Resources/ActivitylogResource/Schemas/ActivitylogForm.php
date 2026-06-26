<?php

namespace Bestora\FilamentActivityLog\Resources\ActivitylogResource\Schemas;

use Bestora\FilamentActivityLog\ActivitylogPlugin;
use Bestora\FilamentActivityLog\Helpers\ActivityLogHelper;
use Bestora\FilamentActivityLog\Resources\ActivitylogResource\ActivitylogResource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class ActivitylogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('causer_id')
                        ->afterStateHydrated(function ($component, ?Activity $record) {
                            return $component->state($record?->causer?->getAttribute('name') ?? '-');
                        })
                        ->label(__('activitylog::forms.fields.causer.label')),

                    TextEntry::make('subject_type')
                        ->state(function (?Activity $record): string {
                            if (! $record?->subject_type) {
                                return '-';
                            }

                            return Str::of($record->subject_type)->afterLast('\\')->headline() . ' # ' . $record->subject_id;
                        })
                        ->url(fn (?Activity $record): ?string => $record ? ActivitylogResource::getResourceUrl($record) : null)
                        ->label(__('activitylog::forms.fields.subject_type.label')),

                    Textarea::make('description')
                        ->label(__('activitylog::forms.fields.description.label'))
                        ->rows(2)
                        ->columnSpan('full'),
                ]),

                Section::make([
                    TextEntry::make('log_name')
                        ->formatStateUsing(function (?Activity $record): string {
                            return $record?->log_name ? ucwords($record->log_name) : '-';
                        })
                        ->label(__('activitylog::forms.fields.log_name.label')),

                    TextEntry::make('event')
                        ->formatStateUsing(function (?Activity $record): string {
                            return $record?->event ? ucwords(__('activitylog::action.event.' . $record->event)) : '-';
                        })
                        ->label(__('activitylog::forms.fields.event.label')),

                    TextEntry::make('created_at')
                        ->label(__('activitylog::forms.fields.created_at.label'))
                        ->formatStateUsing(function (?Activity $record): string {
                            if (! $record?->created_at) {
                                return '-';
                            }

                            $parser = ActivitylogPlugin::get()->getDateParser();

                            return $parser($record->created_at)
                                ->format(ActivitylogPlugin::get()->getDatetimeFormat());
                        }),
                ]),

                Section::make()
                    ->heading(__('activitylog::forms.changes'))
                    ->visible(fn (?Activity $record): bool => $record !== null && filled(ActivityLogHelper::changesFor($record)))
                    ->schema([
                        ViewEntry::make('changes')
                            ->hiddenLabel()
                            ->state(fn (Activity $record): array => ActivityLogHelper::changesFor($record))
                            ->view('activitylog::filament.tables.columns.activity-logs-properties'),
                    ]),
            ]);
    }
}
