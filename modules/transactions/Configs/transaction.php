<?php

return [
    'async' => env('ASYNC_TRANSACTION', false),
    'gateway' => [
        'baseUri' => env('GATEWAY_API_URI')
    ],
    'inform' => [
        'baseUri' => env('INFORM_API_URI')
    ]
];
