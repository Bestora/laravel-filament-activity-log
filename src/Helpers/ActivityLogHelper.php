<?php

namespace Bestora\FilamentActivityLog\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ActivityLogHelper
{
    /**
     * Constrain a query to activities whose diff matches the search term.
     *
     * Mirrors Filament's default column search (a plain `LIKE` over the JSON
     * text) but spans both diff columns — `attribute_changes` (Spatie v5) and
     * `properties` (v4 / manual logs) — so model diffs stay searchable on both
     * versions. Intended to run inside Filament's grouped search closure, where
     * the surrounding `where` already isolates these conditions.
     *
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    public static function applyChangesSearch(Builder $query, string $search): Builder
    {
        return $query
            ->where('attribute_changes', 'like', "%{$search}%")
            ->orWhere('properties', 'like', "%{$search}%");
    }

    /**
     * Resolve the model diff for an activity, tolerant of Spatie v4 and v5.
     *
     * Since spatie/laravel-activitylog v5.0.0, automatic model logging writes
     * the diff to the dedicated `attribute_changes` column, leaving `properties`
     * empty. Earlier versions (and manual `withProperties()` logs) keep it in
     * `properties`. Both share the `['old' => [...], 'attributes' => [...]]`
     * shape, so we prefer `attribute_changes` and fall back to `properties`.
     *
     * @return array<string, mixed>
     */
    public static function changesFor($activity): array
    {
        $changes = filled($activity->attribute_changes)
            ? $activity->attribute_changes
            : $activity->properties;

        if ($changes instanceof Collection) {
            return $changes->toArray();
        }

        return is_array($changes) ? $changes : [];
    }

    /**
     * Checks if a class uses a specific trait.
     *
     * @param  mixed  $class  The class or object instance to check.
     * @param  string  $trait  The fully qualified name of the trait to look for.
     */
    public static function classUsesTrait($class, $trait): bool
    {
        $traits = class_uses_recursive($class);

        return in_array($trait, $traits);
    }

    public static function getResourcePluralName($class): string
    {
        return Str::plural(Str::kebab(class_basename($class)));
    }
}
