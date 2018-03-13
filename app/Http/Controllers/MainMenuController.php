<?php

namespace App\Http\Controllers;
use Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\MessageBag;
use Validator;
class MainMenuController extends Controller
{
  public function MainMenu(Request $request){
    if ($request->session()->has('SESSION_LOGIN')) {
        return view('home');
    }else{
      Log::info('Kosong session'.session('SESSION_LOGIN'));
      $validator = Validator::make($request->all(), [
      ]);
      $validator->errors()->add(Constants::SYS_RC_EMAIL_NOT_FOUND(), Constants::SYS_MSG_EMAIL_NOT_FOUND());
      return redirect('/')->withErrors($validator);
    }


  }
}
