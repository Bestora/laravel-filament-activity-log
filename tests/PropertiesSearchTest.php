<?php

use Bestora\FilamentActivityLog\Helpers\ActivityLogHelper;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

function activityWith(array $attributes): Activity
{
    $activity              = new Activity;
    $activity->description = 'updated';

    foreach ($attributes as $key => $value) {
        $activity->{$key} = $value;
    }

    $activity->save();

    return $activity;
}

function searchActivities(string $term)
{
    return Activity::query()
        ->where(fn (Builder $query) => ActivityLogHelper::applyChangesSearch($query, $term))
        ->pluck('id');
}

it('searches the diff stored in attribute_changes (Spatie v5)', function () {
    $match = activityWith(['attribute_changes' => ['attributes' => ['city' => 'Berlin']]]);
    $other = activityWith(['attribute_changes' => ['attributes' => ['city' => 'Hamburg']]]);

    $results = searchActivities('Berlin');

    expect($results)->toContain($match->id)
        ->not->toContain($other->id);
});

it('searches the diff stored in properties (Spatie v4 / manual logs)', function () {
    $match = activityWith(['properties' => ['attributes' => ['city' => 'Berlin']]]);
    $other = activityWith(['properties' => ['attributes' => ['city' => 'Hamburg']]]);

    $results = searchActivities('Berlin');

    expect($results)->toContain($match->id)
        ->not->toContain($other->id);
});
