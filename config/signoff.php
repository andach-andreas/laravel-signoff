<?php

// config for Andach/LaravelSignoff
return [
    'middleware' => ['web', 'auth'],

    'views' => [
        'show' => 'signoff::show',
    ],

    'enable_signature_pad' => false,
];
