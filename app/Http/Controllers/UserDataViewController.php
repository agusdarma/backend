<?php

namespace App\Http\Controllers;
use Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\MessageBag;
use Validator;
use Datatables;
class UserDataViewController extends Controller
{
  public function init(Request $request){
    Log::debug('UserDataViewController => init()');
    return view('security/userView');
  }

  public static function anyData(){
    $listUserLevel = DB::select('select * from users');
    return datatables()->collection($listUserLevel)->toJson();
  }
}
