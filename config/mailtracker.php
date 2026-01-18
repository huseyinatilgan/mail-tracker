<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Privacy Settings
    |--------------------------------------------------------------------------
    |
    | Control what data is stored in the database.
    |
    */

    'track_ip' => env('TRACK_IP', false),
    'track_user_agent' => env('TRACK_USER_AGENT', false),

    /*
    |--------------------------------------------------------------------------
    | Security & Abuse Prevention
    |--------------------------------------------------------------------------
    |
    */

    'deduplication_window' => env('TRACKING_DEDUPLICATION_MINUTES', 60), // Minutes to ignore repeated opens
    'rate_limit_per_minute' => 60,
];
