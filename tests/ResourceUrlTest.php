<?php

use Bestora\FilamentActivityLog\Resources\ActivitylogResource\ActivitylogResource;
use Spatie\Activitylog\Models\Activity;

it('renders no resource link when the activity has no subject', function () {
    expect(ActivitylogResource::getResourceUrl(new Activity))->toBeNull();
});

it('renders no resource link when the subject id is missing', function () {
    $activity               = new Activity;
    $activity->subject_type = 'App\\Models\\Post';

    expect(ActivitylogResource::getResourceUrl($activity))->toBeNull();
});
