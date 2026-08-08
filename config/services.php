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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'firebase' => [
        'apiKey' => "AIzaSyAyiZi-oi6QilI2X-7hNcCgtbmRT2WL",
        'authDomain' => "astroway.firebaseapp.com",
        'databaseURL' => "https://astroway-default-rtdb.firebaseio.com",
        'projectId' => "astroway",
        'storageBucket' => "astroway.appspot.com",
        'messagingSenderId' => "3810862066",
        'appId' => "1:381086206621:android:4bdb41c9c9a0716b32e274",
        'measurementId' => "G-XRMVXVM97",
    ],
    'zego' => [
    'appID' => env('ZEGO_APP_ID'),
    'serverSecret' => env('ZEGO_SERVER_SECRET'),
    ],
];
