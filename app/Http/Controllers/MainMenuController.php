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
    Log::debug('MainMenu');
    return view('home');
  }
}
