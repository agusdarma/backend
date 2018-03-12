<?php

namespace App\Http\Controllers;

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

    $email = $request->email;
    $password = $request->password;
    $results = DB::select('select * from users where email = :email', ['email' => $email]);
    $listUsers = collect($results);
    if($listUsers->count() == 0){
      // User not found
      $validator->errors()->add('rc.1', __('lang.rc.1'));
      Log::error('Error with '.__('lang.rc.1').' -rc.1');
      return redirect('/')->withErrors($validator)->withInput();
    }
    $passwordDB = $listUsers[0]->password;
    if($password != Crypt::decryptString($passwordDB)){
      // Password Salah
      $validator->errors()->add('rc.2', __('lang.rc.2'));
      Log::error('Error with '.__('lang.rc.2').' -rc.2');
      return redirect('/')->withErrors($validator)->withInput();
    }
    // Query ke DB berhasil
    session(['SESSION_LOGIN' => $email]);
    return redirect('/login/success');

  }

  public function success(){
      return view('home');
  }
}
