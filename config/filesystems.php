<?php
return [
    'media' => [
        'driver' => 'local',
        'root'   => public_path().'/media',
        'visibility' => 'public',
    ],

    'media-private' => [
        'driver' => 'local',
        'root'   => storage_path().'/app/media',
        'visibility' => 'private',
    ],

    'uploads' => [
        'driver' => 'local',
        'root'   => storage_path('uploads'),
    ],
];