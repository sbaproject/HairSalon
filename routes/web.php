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

Route::get('/', function() {
    return view('pages.staff');
});

Route::get('/login', 'UserController@getLogin');

Route::post('/login', 'UserController@postLogin');

Route::get('/logout', 'UserController@logout');

Route::get('/changepassword', 'UserController@getChangePassword');

Route::post('/changepassword', 'UserController@changePassword');

Route::get('/sales', 'SalesController@index');

Route::post('/sales', 'SalesController@postSearch');

Route::get('/sales/new', 'SalesController@getSalesNew');

Route::post('/sales/new', 'SalesController@postSalesNew');

Route::get('/sales/edit/{id}/{index}', 'SalesController@getSalesEdit');

Route::post('/sales/edit/{id}/{index}', 'SalesController@postSalesEdit');

Route::get('/sales/delete/{id}', 'SalesController@getSalesDelete');

Route::get('/staff', 'StaffController@index');

Route::get('/staff/new', 'StaffController@getStaffNew');

Route::post('/staff/new', 'StaffController@postStaffNew');

Route::get('/staff/edit/{id}', 'StaffController@getStaffEdit');

Route::post('/staff/edit/{id}', 'StaffController@postStaffEdit');

Route::get('/staff/delete/{id}', 'StaffController@getStaffDelete');

Route::get('/course', 'CourseController@index');

Route::get('/course/new', 'CourseController@getCourseNew');

Route::post('/course/new', 'CourseController@postCourseNew');

Route::get('/course/delete/{id}', 'CourseController@getCourseDelete');