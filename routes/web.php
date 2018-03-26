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
Route::get('/UserData',[
   'middleware' => 'session',
   'uses' => 'UserDataController@init',
]);
Route::post('/UserData/Add',[
   'middleware' => 'session',
   'uses' => 'UserDataController@add',
]);
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
// Route::get('/UserData/{id}', [
//     'middleware' => 'session',
//     'uses' => 'UserDataController@showEdit',
//      function ($id) {
//         return view('welcome');
// }]);
Route::get('/UserData/showEdit', [
    'middleware' => 'session',
    'uses' => 'UserDataController@showEdit',
]);
