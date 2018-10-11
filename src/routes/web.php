<?php


Route::group([
    'namespace' => 'Ar4ibyitsoftce\Brandslider\Http\Controllers',
    'prefix' => 'admin/',
    'middleware' => ['web']
    ],function(){

    Route::resource( '/slider-brand', 'SliderBrandController', [ 'as' => 'admin', 'only' => ['index', 'store', 'update', 'destroy'] ] );

});