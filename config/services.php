<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '1186916898549115',
        'client_secret' => '5a94e0a728f0b9fc62c0f50bf86866b8',
        'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '450733711462-cp42j54vuvu36mfr8edc065qgsb9klut.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost:8000/login/google/callback',
    ],

    'github' => [
        'client_id' => 'fdfea35a91a8e3ffd940',
        'client_secret' => '5345c96367a652800a8a3382dc0ffcee7d2bf81a',
        'redirect' => 'http://localhost:8000/login/github/callback',
    ],
];
