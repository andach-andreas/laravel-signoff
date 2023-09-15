<?php

// config for Andach/LaravelSignoff
return [
    'middleware' => ['web', 'auth'],

    'views' => [
        'show' => 'signoff::show',
    ],
];
