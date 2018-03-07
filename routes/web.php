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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('welcome2');
});

Route::get('/admin/{id}', function ($id) {
        echo 'ID: '.$id;
});

Route::get('/user/{name?}',function($name = 'Virat'){
    echo "Name: ".$name;
});

Route::get('role',[
    'middleware' => 'role:editor',
    'uses' => 'TestController@index',
]);

Route::get('age',[
    'middleware' => 'Age:editor agus',
    'uses' => 'TestController@index',
]);

Route::get('terminate',[
    'middleware' => 'terminate',
    'uses' => 'ABCController@index',
]);

Route::get('/usercontroller/path',[
    'middleware' => 'first',
    'uses' => 'UserController@showPath'
]);

Route::resource('my','MyController');  

Route::get('/register', function () {
    return view('register');
});

Route::post('/user/register',array('uses'=>'UserRegistration@postRegister'));

Route::get('/cookie/set','CookieController@setCookie');
Route::get('/cookie/get','CookieController@getCookie');

Route::get('blade', function () {
    return view('page',array('name' => 'Virat Gandhi'));
});

Route::get('insert','StudInsertController@insertform');
Route::post('create','StudInsertController@insert');
