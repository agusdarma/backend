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

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Login
Route::get('/', function () {
    return view('login');
});

Route::post('/login/auth', 'LoginController@auth');
Route::get('/MainMenu',[
   'middleware' => 'session',
   'uses' => 'MainMenuController@MainMenu',
]);

// Logout
Route::get('/Logout', 'LoginController@logout');

// User Data
Route::get('/UserData/view',[
   'middleware' => 'session',
   'uses' => 'UserDataController@view',
]);

Route::get('/UserData/view/data',[
   'middleware' => 'session',
   'uses' => 'UserDataController@getListUserData',
])->name('getListUserData');

Route::post('/UserData/AddAjax',[
   'middleware' => 'session',
   'uses' => 'UserDataController@addAjax',
]);

Route::get('/UserData/showEdit', [
    'middleware' => 'session',
    'uses' => 'UserDataController@showEdit',
]);

Route::post('/UserData/editProcess', [
    'middleware' => 'session',
    'uses' => 'UserDataController@editProcess',
]);

// User Level
Route::get('/UserLevel',[
   'middleware' => 'session',
   'uses' => 'UserLevelController@view',
]);

Route::get('/UserLevel/view/data',[
   'middleware' => 'session',
   'uses' => 'UserLevelController@getListUserLevelData',
])->name('getListUserLevelData');

Route::post('/UserLevel/AddAjax',[
   'middleware' => 'session',
   'uses' => 'UserLevelController@addAjax',
]);

Route::get('/UserLevel/showEdit', [
    'middleware' => 'session',
    'uses' => 'UserLevelController@showEdit',
]);

Route::post('/UserLevel/editProcess', [
    'middleware' => 'session',
    'uses' => 'UserLevelController@editProcess',
]);
