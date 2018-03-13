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
    Log::info('Processing auth: '.$request->email);
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
    $passwordDB = $listUsers[0]->password;
    if($password != Crypt::decryptString($passwordDB)){
      // Password Salah
      $validator->errors()->add(Constants::SYS_RC_PASSWORD_NOT_MATCH(), Constants::SYS_MSG_PASSWORD_NOT_MATCH());
      Log::error('Error with '.Constants::SYS_MSG_PASSWORD_NOT_MATCH().' -'.Constants::SYS_RC_PASSWORD_NOT_MATCH());
      return redirect('/')->withErrors($validator)->withInput();
    }
    // Query ke DB berhasil
    $loginData = $app->make('LoginData');
    $loginData->email = $email;
    $loginData->password = $password;
    $loginDataJson = json_encode($loginData);
    // Log::info('Session '.$loginDataJson);
    // $loginData2 = $app->make('LoginData');
    // $loginData2 = json_decode($loginDataJson);
    // Log::info('Session2 '.$loginData2->email);
    session(['SESSION_LOGIN' => $loginDataJson]);
    return redirect('/MainMenu');

  }
}
