<?php

return [
    'connections' => [
        'default' => [
            'endpoint' => env('ELOQUENT_EXTERNAL_EVENTS_API_ENDPOINT'),
            'token' => env('ELOQUENT_EXTERNAL_EVENTS_API_TOKEN', 'test'),
        ],
    ],
];