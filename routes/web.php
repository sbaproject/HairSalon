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

Route::get('/', function()
{
    return View::make('pages.login');
});


Route::get('/pages/{id?}', 'UserController@index');

Route::get('/sales', 'SalesController@index');

Route::get('/sales/new', 'SalesController@getSalesNew');

Route::get('/staff', 'StaffController@index');

Route::get('/staff/new', 'StaffController@getStaffNew');

Route::post('/staff/new', 'StaffController@postStaffNew');

Route::get('/staff/edit/{id}', 'StaffController@getStaffEdit');

Route::post('/staff/edit/{id}', 'StaffController@postStaffEdit');

Route::get('/staff/delete/{id}', 'StaffController@getStaffDelete');

