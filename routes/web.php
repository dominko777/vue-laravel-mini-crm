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

Route::prefix('auth')->group(function() {
    Route::get('init', 'Auth\AppController@init');
    Route::post('login', 'Auth\AppController@login');
    Route::post('register', 'Auth\AppController@register');
    Route::post('logout', 'Auth\AppController@logout');
});

Route::get('companies/index', 'CompaniesController@index');
Route::get('companies/show/{id}', 'CompaniesController@show');
Route::post('companies/create', 'CompaniesController@create');
Route::post('companies/update', 'CompaniesController@update');
Route::post('companies/delete/{id}', 'CompaniesController@delete');

Route::get('employees/index', 'EmployeesController@index');
Route::get('employees/show/{id}', 'EmployeesController@show');
Route::post('employees/create', 'EmployeesController@create');
Route::post('employees/update', 'EmployeesController@update');
Route::post('employees/delete/{id}', 'EmployeesController@delete');