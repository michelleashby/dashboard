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
// Laravel default routes
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

//Default routes will show home page with students if logged in or Welcome screen if not
//All pages are displayed from the PagesController
Route::get('/', 'PagesController@displayHome');
Route::get('/home', 'PagesController@displayHome');
Route::get('/admin', 'PagesController@displayAdmin');
Route::get('/createEmail', 'PagesController@displayCreateEmail');
Route::get('/editEmail/{id}', 'PagesController@displayEditEmail');
Route::get('/editStep/{id}', 'PagesController@displayStep');
Route::get('/dbsync', 'ButtonController@dbsync');

//Form POSTS - go through appropriate controller and redirect back to whatever page BEFORE displaying form
Route::post('/editStep/{id}', 'StepController@editStep');
Route::post('/editEmail/{id}', 'EmailController@saveEmail');
Route::post('/createEmail', 'EmailController@createEmail');

//Search (students) on main page
Route::post('/home/search', 'StudentController@searchStudents');

//Post from home buttons
Route::post('/home/{bit}', 'EmailController@onClick');

