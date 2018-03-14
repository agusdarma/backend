<?php

namespace App\Http\Controllers;
use Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\MessageBag;
use Validator;
class UserDataController extends Controller
{
  public function init(Request $request){
    Log::debug('UserDataController => init()');
    return view('security/user');
  }
}
