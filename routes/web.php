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
    return redirect()->route('dashboard');
});

Auth::routes();
Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Category
    Route::resource('/category', 'CategoryController')->except(['create', 'show']);
    // Job
    Route::resource('/job', 'JobController')->except(['show']);
    // User Management
    Route::resource('/user-management', 'UserController')->except(['create', 'show']);
    // Role || Only for super admin
    Route::group(['middleware' => ['role:super admin']], function () {
        Route::get('/role', 'RoleController@index')->name('role.index');
        Route::put('/role/{role}', 'RoleController@update')->name('role.update');
    });

    Route::group(['prefix' => 'api/datatable', 'as' => 'datatable.'], function () {
        Route::get('/categories', 'CategoryController@dataTable')->name('category');
        Route::get('/users', 'UserController@dataTable')->name('user');
    });

    Route::group(['prefix' => 'api/v1'], function () {
        // Job Post
        Route::post('/job', 'JobController@store');
        // Job Get by ID
        Route::get('/job/{job}', 'JobController@show');
        // Job Update
        Route::patch('/job/{job}', 'JobController@update');
        // Job Delete
        Route::delete('/job/{job}', 'JobController@destroy');
        // Job Departement Delete
        Route::delete('/job/{job}/{departement}', 'JobController@destroyDepartement');
        // Job Departement Task Delete
        Route::delete('/job/{job}/{departement}/{task}', 'JobController@destroyTask');
        // Job Departement Create Policy
        // Route::post('/job/check/create', 'JobController@checkDepartementCreatePolicy');
        Route::post('/job/check/{job}', 'JobController@checkDepartementCreatePolicy');
        // Job Departement Policy
        Route::post('/job/check/{job}/{departement}', 'JobController@checkDepartementPolicy');
        // Notifications
        Route::post('/mark-as-read/{id}', function ($id) {
            $notification = auth()->user()->notifications()->whereId($id)->firstOrFail();

            $notification->markAsRead();
        });
    });
});
