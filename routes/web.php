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

Route::get('/', function () {
    return view('login');
});

Route::post('/login/auth', 'LoginController@auth');
Route::get('/MainMenu',[
   'middleware' => 'session',
   'uses' => 'MainMenuController@MainMenu',
]);
Route::get('/Logout', 'LoginController@logout');
