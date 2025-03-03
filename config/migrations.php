<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */
    'table' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Migration Directory Path
    |--------------------------------------------------------------------------
    |
    | This directory is where all migrations will be stored. This path is
    | relative to the application root.
    |
    */
    'path' => database_path('migrations'),

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Connection
    |--------------------------------------------------------------------------
    |
    | This is the database connection that will be used by the migration
    | repository. This connection should be properly configured in your
    | database configuration file.
    |
    */
    'connection' => null,
];;