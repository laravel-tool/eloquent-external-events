<?php

return [
    'excluded_events' => [
        'booting',
        'booted',
        'retrieved',
//        'creating',
//        'created',
//        'updating',
//        'updated',
//        'saving',
//        'saved',
//        'restoring',
//        'restored',
//        'replicating',
//        'deleting',
//        'deleted',
//        'forceDeleting',
//        'forceDeleted',
    ],
    'connections' => [
        'default' => [
            'endpoint' => env('ELOQUENT_EXTERNAL_EVENTS_API_ENDPOINT'),
            'token' => env('ELOQUENT_EXTERNAL_EVENTS_API_TOKEN', 'test'),
        ],
    ],
];