<?php

return [
    'token' => env('GITHUB_TOKEN', ''),
    'owner' => env('GITHUB_OWNER', ''),
    'components' => [
        'repos' => [
            'per_page' => 10,
        ],
    ],
];
