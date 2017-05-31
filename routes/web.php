<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',                       'EmployeeController@welcome');

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout'); //Just added to fix issue

Route::group(['middleware' => ['auth']], function() {
    Route::group(['prefix' => 'employees'], function () {
        Route::get('/',               'EmployeeController@index');
        Route::get('/create/',        'EmployeeController@create');
        Route::post('/store',         'EmployeeController@store');
        Route::get('/edit/{id}',      'EmployeeController@edit')
             ->where('id', '[0-9]+');
        Route::post('/update/{id}',   'EmployeeController@update')
             ->where('id', '[0-9]+');
        Route::get('/delete/{id}',    'EmployeeController@destroy')
             ->where('id', '[0-9]+');
        Route::get('/search',        'EmployeeController@search');
    });
});

Route::get('/tree',                  'EmployeeController@tree');
Route::get('/gettree',               'EmployeeController@getTree');