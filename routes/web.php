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
    return view('/backend/login');
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

Route::get('view-records','StudViewController@index');


Route::get('edit-records','StudUpdateController@index');
Route::get('edit/{id}','StudUpdateController@show');
Route::post('edit/{id}','StudUpdateController@edit');

Route::get('delete-records','StudDeleteController@index');
Route::get('delete/{id}','StudDeleteController@destroy');

Route::get('/form',function(){
    return view('form');
});

Route::get('localization/{locale}','LocalizationController@index');


Route::get('session/get','SessionController@accessSessionData');
Route::get('session/set','SessionController@storeSessionData');
Route::get('session/remove','SessionController@deleteSessionData');

Route::get('/validation','ValidationController@showform');
Route::post('/validation','ValidationController@validateform');

Route::get('/uploadfile','UploadFileController@index');
Route::post('/uploadfile','UploadFileController@showUploadFile');

Route::get('ajax',function(){
    return view('message');
});
Route::post('/getmsg','AjaxController@index');

Route::get('event','CreateStudentController@insertform');
Route::post('addstudent','CreateStudentController@insert');
