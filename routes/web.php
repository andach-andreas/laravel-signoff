<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => config('signoff.middleware')], function () {
    Route::get('/signoff/{object}/{id}', 'Andach\LaravelSignoff\Controllers\SignoffController@show')->name('signoff.show');
    Route::post('/signoff/{object}/{id}/first', 'Andach\LaravelSignoff\Controllers\SignoffController@firstPost')->name('signoff.first-post');
    Route::post('/signoff/{object}/{id}/second', 'Andach\LaravelSignoff\Controllers\SignoffController@secondPost')->name('signoff.second-post');


    Route::get('/signoff/test', function () {
        return 'a';
    });
});

