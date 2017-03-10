<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'legacy', 'namespace' => 'Legacy'], function () {
    CRUD::resource('flower', 'FlowerController');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' =>  'admin'], function () {
    CRUD::resource('addenda', 'AddendaController');
});

Route::get('/', function(){
    return redirect('admin');
});
