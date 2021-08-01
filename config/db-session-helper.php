<?php

return [

    /*
     * When determine if a user should be marked as logged in or logged out we have to define
     * a time span after how many minutes without interacting with your application
     * users were marked as logged out.
     * You can change the value to anything you like.
     */

    'login_time_span' => 10,

    /*
     * When using the HasDatabaseSessions trait from this package we have to determine which
     * Eloquent model should be used to retrieve your sessions.
     *
     * The model you want to use as a Session model need to implement the
     * `Geisi\LaravelDbSessionHelper\Contracts\Session` contract.
     *
     */

    'models' => [
        'session' => \Geisi\LaravelDbSessionHelper\Models\Session::class
    ]
];
