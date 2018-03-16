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
class UserDataController extends Controller
{
  public function init(Request $request){
    Log::debug('UserDataController => init()');
    return view('security/user');
  }

  public static function listUserLevel($levelId){
    $listUserLevel = DB::select('select * from user_level l where l.id = :levelId
    ', ['levelId' => $levelId]);
    return $listUserLevel;
  }

  public function add(Request $request){
    Log::debug('UserDataController => add()');
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
           return redirect('/UserData')->withErrors($validator)->withInput();
    }
    $firstName = $request->firstName;
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
    DB::insert('insert into users (first_name, last_name,email,phone_no,group_id,invalid_count,gender,
    username, status, password, store, created_by,updated_by) values (:firstName, :lastName, :email, :phoneNo,
     :userLevel, :invalidCount, :gender, :userName, :status, :password, :store, :createdBy, :updatedBy)',
    ['firstName' => $firstName, 'lastName' => $lastName , 'email' => $email , 'phoneNo' => $phoneNo
    , 'userLevel' => $userLevel, 'gender' => $gender, 'userName' => $userName, 'password' => $password
    , 'store' => $store, 'invalidCount' => $invalidCount, 'status' => $status, 'createdBy' => $createdBy,
     'updatedBy' => $updatedBy]);
    $request->session()->flash('message.level', Constants::SYS_MSG_LEVEL_SUCCESS());
    $request->session()->flash('message.content', Constants::SYS_MSG_USER_SUCCESS_ADDED());
    // $request->session()->flash('message.level', 'danger');
    // $request->session()->flash('message.content', 'Error!');
    return redirect('/UserData');
  }

  public function view(Request $request){
    Log::debug('UserDataController => view()');
    return view('security/userView');
  }

  public static function getListUserData(){
    $listUsers = DB::select('select u.id,u.first_name,u.email,u.phone_no,l.level_name
    from users u inner join user_level l on u.group_id = l.id');
    return datatables($listUsers)
    ->addColumn('action', function ($listUsers) {
        return '<a href="#edit-'.$listUsers->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    })
    ->toJson();



  }

}
