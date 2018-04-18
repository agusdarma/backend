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
class ResetPasswordController extends Controller
{

  public function view(Request $request){
    Log::debug('ResetPasswordController => view()');
    return view('security/ResetPassword');
  }

  public static function listUser(){
    $listUser = DB::select('select * from users l where l.status = :status
    ', ['status' => Constants::CONSTANTS_ACTIVE()]);
    return $listUser;
  }

  public function change(Request $request){
    Log::debug('ResetPasswordController => change()');
    // validasi input
    $validator = Validator::make($request->all(), [
            'user' => 'required',
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
    $user = $request->user;
    $newPassword = $request->newPassword;
    $confirmPassword = $request->confirmPassword;
    // Log::debug($user);
    // Log::debug($newPassword);
    // Log::debug($confirmPassword);

    $app = app();
    $loginDataJson = session(Constants::CONSTANTS_SESSION_LOGIN());
    $loginData2 = $app->make('LoginData');
    $loginData2 = json_decode($loginDataJson);
    $createdBy = $loginData2->id;
    $updatedBy = $loginData2->id;


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
        ,'id' => $user,'updatedBy' => $updatedBy]);
        Log::debug('user yg mau diubah.'.$user);
        DB::commit();
        // DB::rollback();
        $response = array('level' => Constants::SYS_MSG_LEVEL_SUCCESS(),
        'message' => Constants::SYS_MSG_RESET_PASSWORD_SUCCESS_CHANGED(),
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
