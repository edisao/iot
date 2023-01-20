<?php

return [

    'formats' => [
        'format_date' => 'Y-m-d H:i:s',
    ],
    'sizes' => [
        'resource_image' => '1200', // pixels
    ],
    'authentication' => [
        'timeout' => '180', // minutes
    ],
    'jwt_token' => [
        'exp' => '180', // minutes, token expired
    ],
    'path_resource' => [
        'public' => 'public',
        'storage' => 'storage',
        'sites' => 'sites',
        'user' => 'user',
    ]

];
