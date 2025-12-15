<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable or Disable Package Assets Loading
    |--------------------------------------------------------------------------
    |
    | If your host application already provides Bootstrap 5, Chart.js, and
    | Font Awesome in its layout, set this value to false to avoid duplicates.
    |
    */

    'provide_assets' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout Used by Package Views
    |--------------------------------------------------------------------------
    |
    | By default, the package uses its own minimal layout.
    | Replace this with your application's layout if needed.
    |
    */

    'layout' => 'laravisitors::layouts.minimal',

    /*
    |--------------------------------------------------------------------------
    | Access Middleware
    |--------------------------------------------------------------------------
    |
    | List of middlewares applied to the package routes.
    | Default: ['web', 'auth', 'laravisitors.access']
    | Example: ['web', 'auth', 'role:amdin'] 
    |
    */

    'access_middleware' => ['web', 'auth', 'laravisitors.access'],

    /*
    |--------------------------------------------------------------------------
    | Visits Table Name
    |--------------------------------------------------------------------------
    |
    | The name of the visits table, identical to the one used by the
    | shetabit/visitor package.
    |
    */

    'visits_table' => env('LARAVISITORS_TABLE', 'shetabit_visits'),

    /*
    |--------------------------------------------------------------------------
    | User Model Class
    |--------------------------------------------------------------------------
    |
    | The fully qualified class name of the User model.
    |
    */

    'user_model' => env('LARAVISITORS_USER_MODEL', App\Models\User::class),

];