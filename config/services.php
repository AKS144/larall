<?php

return [


    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

  /*  'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],*/
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '147611400116444',
        'client_secret' => '4bc474793563cf63a31e10a085f6659a',
        'redirect' => 'http://localhost:8000/login/facebook/callback'
    ],

    'twitter' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => 'http://127.0.0.1:8000/login/twitter/callback'
    ],

    'google' => [
        'client_id' => '80951699396-uoj861h4doco12hlngt7hkt10gg60br9.apps.googleusercontent.com',
        'client_secret' => 'kqkyZjgsliSQ-rKhj2_8Y_2c',
        'redirect' => 'http://localhost:8000/login/google/callback'
    ],

];
