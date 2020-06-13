<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Category
    Route::resource('/category', 'CategoryController')->except(['create', 'show']);
    // Job
    Route::resource('/job', 'JobController')->except(['show']);

    Route::group(['prefix' => 'api/datatable', 'as' => 'datatable.'], function () {
        Route::get('/categories', 'CategoryController@dataTable')->name('category');
    });

    Route::group(['prefix' => 'api/v1'], function () {
        Route::post('/job', 'JobController@store');
        Route::get('/job/{job}', 'JobController@show');
    });
});
