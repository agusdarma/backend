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
class ChangePasswordController extends Controller
{

  public function view(Request $request){
    Log::debug('ChangePasswordController => view()');
    return view('security/ChangePassword');
  }

  public static function getListUserLevelData(){
    $listUserLevels = DB::select('select l.id,l.level_name,l.level_desc
    from user_level l');
    return datatables($listUserLevels)
    ->addColumn('action', function ($listUserLevels) {
        return '<a href="#" onclick="edit('.$listUserLevels->id.')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    })
    ->toJson();
  }

  public function change(Request $request){
    Log::debug('ChangePasswordController => change()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required',

    ]);

    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           $response = array('errors' => $validator->getMessageBag(),
           'rc' => Constants::SYS_RC_VALIDATION_INPUT_ERROR());
             Log::debug(Response::json($response));
           return Response::json($response);
    }
    $oldPassword = $request->oldPassword;
    $newPassword = $request->newPassword;
    $confirmPassword = $request->confirmPassword;

    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    $createdBy = $loginData2->id;
    $updatedBy = $loginData2->id;
    // cari user dari db
    $user = DB::table('users')->where('id', $loginData2->id)->first();
    if(collect($user)->isEmpty()){
      $response = array('errors' => array('message' => Constants::SYS_MSG_USER_NOT_FOUND()),
      'rc' => Constants::SYS_RC_USER_NOT_FOUND());
      Log::debug(Response::json($response));
      return Response::json($response);
    }
    // cek password lama dengan inputan //
    $oldPasswordDb = $user->password;
    // Log::debug($oldPassword);
    // Log::debug(Crypt::decryptString($oldPasswordDb));
    if(Crypt::decryptString($oldPasswordDb)<>$oldPassword){
      $response = array('errors' => array('message' => Constants::SYS_MSG_INVALID_OLD_PASSWORD()),
      'rc' => Constants::SYS_RC_INVALID_OLD_PASSWORD());
      Log::debug(Response::json($response));
      return Response::json($response);
    }
    // get min length $password
    $ResultDB = DB::select('select * from system_setting where id = :id', ['id' => Constants::MIN_LENGTH_PASSWORD()]);
    $minPasswordLength = $ResultDB[0]->setting_value;

    // cek new password harus sama dengan confirm password
    if($newPassword<>$confirmPassword){
      $response = array('errors' => array('message' => Constants::SYS_MSG_INVALID_NEW_PASSWORD_CONFIRM_PASSWORD()),
      'rc' => Constants::SYS_RC_INVALID_NEW_PASSWORD_CONFIRM_PASSWORD());
      Log::debug(Response::json($response));
      return Response::json($response);
    }

    // panjang password harus sesuai dengan panjang di settingan db
    if(strlen($newPassword) < $minPasswordLength){
      $response = array('errors' =>
      array('message' => Constants::SYS_MSG_INVALID_MIN_PASSWORD_LENGTH($minPasswordLength)),
      'rc' => Constants::SYS_RC_INVALID_MIN_PASSWORD_LENGTH());
      Log::debug(Response::json($response));
      return Response::json($response);
    }

    // password harus alphanumeric dan special character
    $hasil = preg_match('/^.*(?=.{'.$minPasswordLength.',})(?=.*\\d)(?=.*[a-zA-Z])(?=.*[^A-Za-z0-9]).*$/',$newPassword);
    // Log::debug("hasil : ".$hasil);
    if($hasil == 0){
      $response = array('errors' =>
      array('message' => Constants::SYS_MSG_INVALID_PASSWORD_FORMAT()),
      'rc' => Constants::SYS_RC_INVALID_PASSWORD_FORMAT());
      Log::debug(Response::json($response));
      return Response::json($response);
    }

    DB::beginTransaction();
    try {
        $results = DB::update('update users set password = :password, updated_at = CURRENT_TIMESTAMP
        , updated_by = :updatedBy
        where id = :id', ['password' => Crypt::encryptString($newPassword)
        ,'id' => $user->id,'updatedBy' => $updatedBy]);
        DB::commit();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_CHANGE_PASSWORD_SUCCESS_CHANGED(),
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
