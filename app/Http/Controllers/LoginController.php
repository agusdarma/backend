<?php

namespace App\Http\Controllers;
use Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Crypt;
use Validator;
class LoginController extends Controller
{
  public function auth(Request $request){
    Log::debug('Processing auth: '.$request->email);
    // validasi input
    $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
    ]);
    // Jika input gagal redirect ke login page
    if ($validator->fails()) {
           Log::warn('Error validasi input ');
           return redirect('/')->withErrors($validator)->withInput();
    }
    $app = app();

    $email = $request->email;
    $password = $request->password;
    $results = DB::select('select * from users where email = :email', ['email' => $email]);
    $listUsers = collect($results);
    if($listUsers->count() == 0){
      // User not found
      $validator->errors()->add(Constants::SYS_RC_EMAIL_NOT_FOUND(), Constants::SYS_MSG_EMAIL_NOT_FOUND());
      Log::error('Error with '.Constants::SYS_MSG_EMAIL_NOT_FOUND().' -'.Constants::SYS_RC_EMAIL_NOT_FOUND());
      return redirect('/')->withErrors($validator)->withInput();
    }
    $id = $listUsers[0]->id;
    $now=time();
    // check user active atau inactive
    $status = $listUsers[0]->status;
    if($status != Constants::CONSTANTS_ACTIVE()){
      // user tidak aktif
      $validator->errors()->add(Constants::SYS_RC_USER_NOT_ACTIVE(), Constants::SYS_MSG_USER_NOT_ACTIVE());
      Log::error('Error with '.Constants::SYS_MSG_USER_NOT_ACTIVE().' -'.Constants::SYS_RC_USER_NOT_ACTIVE());
      return redirect('/')->withErrors($validator)->withInput();
    }
    // check invalid count user
    $invalidCount = $listUsers[0]->invalid_count;
    $ResultDB = DB::select('select * from system_setting where id = :id', ['id' => Constants::MAX_INVALID_LOGIN()]);
    $maxInvalidLogin = $ResultDB[0]->setting_value;
    Log::info('$invalidCount : '.$invalidCount);
    Log::info('$maxInvalidLogin : '.$maxInvalidLogin);
    if ($invalidCount >= $maxInvalidLogin){
        // user sudah invalid lebih dari maximal
        $validator->errors()->add(Constants::SYS_RC_USER_BLOCKED(), Constants::SYS_MSG_USER_BLOCKED());
        Log::error('Error with '.Constants::SYS_MSG_USER_BLOCKED().' -'.Constants::SYS_RC_USER_BLOCKED());
        return redirect('/')->withErrors($validator)->withInput();
    }
    // check user password
    $passwordDB = $listUsers[0]->password;
    if($password != Crypt::decryptString($passwordDB)){
      // Password Salah
      $validator->errors()->add(Constants::SYS_RC_PASSWORD_NOT_MATCH(), Constants::SYS_MSG_PASSWORD_NOT_MATCH());
      Log::error('Error with '.Constants::SYS_MSG_PASSWORD_NOT_MATCH().' -'.Constants::SYS_RC_PASSWORD_NOT_MATCH());
      // update invalid count db
      $invalidCount = $invalidCount + 1;
      $results = DB::update('update users set invalid_count = :invalid_count, updated_at = CURRENT_TIMESTAMP
      where id = :id', ['invalid_count' => $invalidCount,'id' => $id]);
      return redirect('/')->withErrors($validator)->withInput();
    }
    // Jika success harus reset invalid count nya
    $invalidCount = 0;
    $results = DB::update('update users set invalid_count = :invalid_count, updated_at = CURRENT_TIMESTAMP
    where id = :id', ['invalid_count' => $invalidCount,'id' => $id]);

    $loginData = $app->make('LoginData');
    $loginData->email = $email;
    $loginData->password = $password;
    $loginData->groupId = $listUsers[0]->group_id;
    $loginData->firstName = $listUsers[0]->first_name;
    $loginData->lastName = $listUsers[0]->last_name;
    $loginDataJson = json_encode($loginData);
    session([Constants::CONSTANTS_SESSION_LOGIN() => $loginDataJson]);
    return redirect('/MainMenu');

  }

  public function logout(Request $request){
      Log::debug('Processing logout');
      $request->session()->forget(Constants::CONSTANTS_SESSION_LOGIN());
      return redirect('/');
  }
}
