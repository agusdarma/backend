<?php

namespace App\Http\Controllers;
use Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
// use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\MessageBag;
use Validator;
use Response;
use Carbon;
class UserDataController extends Controller
{
  // public function init(Request $request){
  //   Log::debug('UserDataController => init()');
  //   return view('security/user');
  // }

  public static function listUserLevel($levelId){
    $listUserLevel = DB::select('select * from user_level l where l.id = :levelId
    ', ['levelId' => $levelId]);
    return $listUserLevel;
  }

  public static function listUserLevelAll(){
    $listUserLevel = DB::select('select * from user_level l ');
    return $listUserLevel;
  }

  // public function add(Request $request){
  //   Log::debug('UserDataController => add()');
  //   // validasi input
  //   $validator = Validator::make($request->all(), [
  //           'firstName' => 'required',
  //           'email' => 'required|email',
  //           'phoneNo' => 'required',
  //           'userLevel' => 'required',
  //           'gender' => 'required',
  //           'password' => 'required',
  //
  //   ]);
  //   // Jika input gagal redirect ke login page
  //   if ($validator->fails()) {
  //          Log::warn('Error validasi input ');
  //          return redirect('/UserData')->withErrors($validator)->withInput();
  //   }
  //   $firstName = $request->firstName;
  //   $lastName = $request->lastName;
  //   $email = $request->email;
  //   $phoneNo= $request->phoneNo;
  //   $userLevel= $request->userLevel;
  //   $gender= $request->gender;
  //   $userName= $request->userName;
  //   $password = Crypt::encryptString($request->password);
  //   $store= $request->store;
  //   $app = app();
  //   $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
  //   $loginData2 = $app->make('LoginData');
  //   $loginData2 = json_decode($loginDataJson);
  //   $createdBy = $loginData2->id;
  //   $updatedBy = $loginData2->id;
  //   $invalidCount = 0;
  //   $status = 'active';
  //   DB::insert('insert into users (first_name, last_name,email,phone_no,group_id,invalid_count,gender,
  //   username, status, password, store, created_by,updated_by) values (:firstName, :lastName, :email, :phoneNo,
  //    :userLevel, :invalidCount, :gender, :userName, :status, :password, :store, :createdBy, :updatedBy)',
  //   ['firstName' => $firstName, 'lastName' => $lastName , 'email' => $email , 'phoneNo' => $phoneNo
  //   , 'userLevel' => $userLevel, 'gender' => $gender, 'userName' => $userName, 'password' => $password
  //   , 'store' => $store, 'invalidCount' => $invalidCount, 'status' => $status, 'createdBy' => $createdBy,
  //    'updatedBy' => $updatedBy]);
  //   $request->session()->flash('message.level', Constants::SYS_MSG_LEVEL_SUCCESS());
  //   $request->session()->flash('message.content', Constants::SYS_MSG_USER_SUCCESS_ADDED());
  //   // $request->session()->flash('message.level', 'danger');
  //   // $request->session()->flash('message.content', 'Error!');
  //   return redirect('/UserData');
  // }

  public function addAjax(Request $request){
    Log::debug('UserDataController => addAjax()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'email' => 'required|email',
            'phoneNo' => 'required',
            'userLevel' => 'required',
            'gender' => 'required',
            'password' => 'required',

    ]);
    // Jika input gagal redirect ke login page
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
           return Response::json($response);
    }
    $firstName = $request->firstName;
    Log::info('First name Input '.$firstName);
    $lastName = $request->lastName;
    $email = $request->email;
    $phoneNo= $request->phoneNo;
    $userLevel= $request->userLevel;
    $gender= $request->gender;
    $userName= $request->userName;
    $password = Crypt::encryptString($request->password);
    $store= $request->store;
    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    $createdBy = $loginData2->id;
    $updatedBy = $loginData2->id;
    $invalidCount = 0;
    $status = 'active';
    DB::beginTransaction();

    try {
      Log::info('mulai insert '.$firstName);
        DB::insert('insert into users (first_name, last_name,email,phone_no,group_id,invalid_count,gender,
        username, status, password, store, created_by,updated_by) values (:firstName, :lastName, :email, :phoneNo,
         :userLevel, :invalidCount, :gender, :userName, :status, :password, :store, :createdBy, :updatedBy)',
        ['firstName' => $firstName, 'lastName' => $lastName , 'email' => $email , 'phoneNo' => $phoneNo
        , 'userLevel' => $userLevel, 'gender' => $gender, 'userName' => $userName, 'password' => $password
        , 'store' => $store, 'invalidCount' => $invalidCount, 'status' => $status, 'createdBy' => $createdBy,
         'updatedBy' => $updatedBy]);
        DB::commit();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_USER_SUCCESS_ADDED(),
        'rc' => '0');
    } catch (\Exception $e) {
        Log::info('error db '.$e->getMessage());
        DB::rollback();
        $response = array('message' => Constants::SYS_MSG_UNKNOWN_ERROR(),
        'rc' => Constants::SYS_RC_UNKNOWN_ERROR(),
        'errors' => '');
    }
    return Response::json($response);
  }

  public function view(Request $request){
    Log::debug('UserDataController => view()');
    return view('security/userView');
  }

  public static function getListUserData(){
    $listUsers = DB::select('select u.id,u.first_name,u.email,u.phone_no,l.level_name,u.status
    from users u inner join user_level l on u.group_id = l.id');
    return datatables($listUsers)
    ->addColumn('action', function ($listUsers) {
        return '<a href="#" onclick="edit('.$listUsers->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    })
    ->toJson();
  }

  public function showEdit(Request $request){
    Log::debug('UserDataController => showEdit()');
    $id = $request->id;
    Log::debug('id => '.$id);
    $listUsers = DB::select('select u.id,u.first_name,u.last_name,u.email,u.phone_no,l.level_name,u.gender,u.username
    ,u.store,l.id as level_id,u.status as status
    from users u inner join user_level l on u.group_id = l.id
    where u.id = :id', ['id' => $id]);
    return Response::json($listUsers);
  }

  public function editProcess(Request $request){
    Log::debug('UserDataController => editProcess()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'email' => 'required|email',
            'phoneNo' => 'required',
            'userLevel' => 'required',
            'gender' => 'required',

    ]);
    // Jika input gagal redirect ke login page
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
           return Response::json($response);
    }
    $id = $request->id;
    $firstName = $request->firstName;
    Log::info('First name Input '.$firstName);
    Log::info('Edit ID Input '.$id);
    $lastName = $request->lastName;
    $email = $request->email;
    $phoneNo= $request->phoneNo;
    $userLevel= $request->userLevel;
    $gender= $request->gender;
    $userName= $request->userName;
    $store= $request->store;
    $status= $request->status;
    Log::info('Status input '.$status);
    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    $createdBy = $loginData2->id;
    $updatedBy = $loginData2->id;
    $invalidCount = 0;
    $updated_at = Carbon\Carbon::now(Constants::ASIA_TIMEZONE());
    Log::info('Update at '.$updated_at);
    DB::beginTransaction();

    try {
      Log::info('mulai edit '.$firstName);
        DB::update('UPDATE users set first_name = :firstName, last_name = :lastName,email = :email,
          phone_no = :phoneNo ,group_id = :userLevel,gender = :gender,username = :userName,
          store = :store,status = :status,updated_by = :updatedBy,updated_at = :updated_at where id = :id',
        ['firstName' => $firstName, 'lastName' => $lastName , 'email' => $email , 'phoneNo' => $phoneNo
        , 'userLevel' => $userLevel, 'gender' => $gender, 'userName' => $userName, 'store' => $store
        , 'status' => $status ,'updatedBy' => $updatedBy,'id' => $id,'updated_at' => $updated_at]);
        DB::commit();
        // DB::rollback();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_USER_SUCCESS_EDITED(),
        'rc' => '0');
    } catch (\Exception $e) {
        Log::info('error db '.$e->getMessage());
        DB::rollback();
        $response = array('message' => Constants::SYS_MSG_UNKNOWN_ERROR(),
        'rc' => Constants::SYS_RC_UNKNOWN_ERROR(),
        'errors' => '');
    }
    return Response::json($response);
  }

}
