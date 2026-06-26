<?php

use Bestora\FilamentActivityLog\Helpers\ActivityLogHelper;
use Spatie\Activitylog\Models\Activity;

it('reads the model diff from attribute_changes on Spatie v5', function () {
    $activity                    = new Activity;
    $activity->attribute_changes = [
        'old'        => ['name' => 'Old name'],
        'attributes' => ['name' => 'New name'],
    ];

    expect(ActivityLogHelper::changesFor($activity))->toBe([
        'old'        => ['name' => 'Old name'],
        'attributes' => ['name' => 'New name'],
    ]);
});

it('falls back to properties when attribute_changes is empty (Spatie v4 / manual logs)', function () {
    $activity             = new Activity;
    $activity->properties = [
        'old'        => ['name' => 'Old name'],
        'attributes' => ['name' => 'New name'],
    ];

    expect(ActivityLogHelper::changesFor($activity))->toBe([
        'old'        => ['name' => 'Old name'],
        'attributes' => ['name' => 'New name'],
    ]);
});

it('prefers attribute_changes over properties when both are present', function () {
    $activity                    = new Activity;
    $activity->attribute_changes = ['attributes' => ['status' => 'active']];
    $activity->properties        = ['attributes' => ['status' => 'legacy']];

    expect(ActivityLogHelper::changesFor($activity))->toBe([
        'attributes' => ['status' => 'active'],
    ]);
});

it('returns an empty array when neither column holds a diff', function () {
    expect(ActivityLogHelper::changesFor(new Activity))->toBe([]);
});
