<?php

use Bestora\FilamentActivityLog\Resources\ActivitylogResource\ActivitylogResource;

return [
    'resources' => [
        'label'                     => 'Activity Log',
        'plural_label'              => 'Activity Logs',
        'hide_restore_action'       => false,
        'restore_action_label'      => 'Restore',
        'hide_resource_action'      => false,
        'hide_restore_model_action' => true,
        // When true, the "Changes" column is hidden by default and can be toggled on per user.
        'hide_properties_column_by_default' => false,
        'resource_action_label'             => 'View',
        'navigation_item'                   => true,
        'navigation_group'                  => null,
        'navigation_icon'                   => 'heroicon-o-shield-check',
        'navigation_sort'                   => null,
        'default_sort_column'               => 'id',
        'default_sort_direction'            => 'desc',
        'navigation_count_badge'            => false,
        'resource'                          => ActivitylogResource::class,
    ],
    'date_format'     => 'd/m/Y',
    'datetime_format' => 'd/m/Y H:i:s',
];
